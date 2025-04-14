<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $stockOuts = $user->stockOuts()->with('product')->get();
        $products = $user->products()->get();
        return view('stockout.index', compact('stockOuts', 'user', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stockOut.index');
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
            $user = Auth::user();
            $request->validate([
                'product_id'=>'required|exists:products,id',
                'quantity'=>'required|integer|min:1'
            ]);
            $product = Product::findOrFail($request->product_id);
            $old_quantity = $product->quantity;
            $new_quantity = $request->quantity;

            if($new_quantity > $old_quantity ){
                return back()->withErrors(['product'=>'Insufficient stock!']);
            }
            $remaining = $old_quantity - $new_quantity;
            $product->update(['quantity'=>$old_quantity - $new_quantity]);
            $total_price = $product->price * $request->quantity;
            
            StockOut::create([
                'product_id'=>$request->product_id,
                'quantity'=> $request->quantity,
                'total_price'=> $total_price,
                'user_id'=>$user->id
            ]);

            return back()->with('success', "Stock Out success remaining $remaining in stock!");

        }catch(\Exception $e) {
            dd($e->getMessage());
            return back()->withErrors('stockIn', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockOut  $stockOut
     * @return \Illuminate\Http\Response
     */
    public function show(StockOut $stockOut)
    {
        if($stockOut->user_id !== auth()->id()) {
            abort(403, 'Unauthorized!');
        }
        return view('stockOut.show', compact('stockOut'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockOut  $stockOut
     * @return \Illuminate\Http\Response
     */
    public function edit(StockOut $stockout)
    {
        $user = Auth::user();
        $products = $user->products()->get();
        return view('stockOut.edit', compact('stockout', 'user', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockOut  $stockOut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockOut $stockout)
    {
        if($stockout->user_id !== auth()->id()) {
            abort(403, 'Unauthorized!');
        }
        $request->validate([
            'product_id'=> 'required|exists:products,id',
            'quantity'=>'required|integer|min:1',
        ]);
        $product = Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;
        $data = $request->all();
        $data['total_price'] = $total_price;
        $current_stockout_quantity = $stockout->quantity;
        $new_stockout_quantity=$request->quantity;
        $stockout->update($data);
        $product->update(['quantity'=>$product->quantity + $current_stockout_quantity]);
        $product->update(['quantity'=>$product->quantity - $new_stockout_quantity]);
        return redirect('/stockout')->with('success', 'Stock Out Transaction aupdated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockOut  $stockOut
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockOut $stockOut)
    {
        if($stockOut->user_id !== auth()->id()) {
            abort(403, 'Unauthorized!');
        }
        $stockOut->delete();
        return view('stockOut.index')->with('success', 'Stock Out transaction deleted successfully!');
    }
}
