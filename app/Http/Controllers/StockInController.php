<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $stockIns = $user->stockins()->with('product')->get();
        $products = $user->products()->get();
        return view('stockIn.index',compact('stockIns', 'user', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('stockIn.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'supplier_name' => 'required|string|max:255'
            ]);

            $product = Product::findOrFail($request->product_id);
            $total_price = $product->price * $request->quantity;
            $data['user_id'] = Auth::user()->id;
            $data['total_price'] = $total_price;
            $old_quantity = $product->quantity;
            $new_quantity = $request->quantity;
            $product->update(['quantity'=> $old_quantity + $new_quantity]);
            StockIn::create($data);
            return back()->with('success', 'Product added successfully!');
        }catch (\Exception $e) {
            dd($e->getMessage());
            return back()->withErrors('stockin', 'Adding product in Failed!');
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockIn  $stockIn
     * @return \Illuminate\Http\Response
     */
    public function show(StockIn $stockin)
    {   
        if($stockin->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('stockin.show', compact('stockIn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockIn  $stockIn
     * @return \Illuminate\Http\Response
     */
    public function edit(StockIn $stockin)
    {
        // if($stockIn->user_id !== auth()->id()) {
        //     abort(403, 'Unauthorized');
        // }
        $user = Auth::user();
        $products = $user->products()->get();
        return view('stockIn.edit', compact('stockin', 'products', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockIn  $stockIn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockIn $stockin)
    {
        
        // if($stockIn->user_id !== auth()->id()) {
        //     abort(403, 'Unauthorized');
        // }
        $request->validate([
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|numeric|min:1',
        ]);
        $product = Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;
        $data = $request->all();
        $data['total_price'] = $total_price;
        $stockin->update($data);
        $product->update(['quantity'=>$request->quantity]);
         return redirect('/stockin')->with('success', 'Stock in transaction recorded successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockIn  $stockIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockIn $stockin)
    {
        
        if($stockin->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $stockin->delete();
        return view('stockIn.index')->with('success', 'Stock In transaction deleted successfully!');
    }
}
