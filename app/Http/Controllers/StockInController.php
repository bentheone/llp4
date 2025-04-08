<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockIns = StockIn::all();
        return view('stockIn.index',compact('stockIns'));
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
            $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);
            $total_price = $product->price * $request->quantity;
            $data = $request->all();
            $data['total_price'] = $total_price;
            StockIn::create($data);
            return back()->with('success', 'Product added successfully!');
        }catch (\Exception $e) {

        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockIn  $stockIn
     * @return \Illuminate\Http\Response
     */
    public function show(StockIn $stockIn)
    {   
        if($stockIn->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('stockIn.show', compact('stockIn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockIn  $stockIn
     * @return \Illuminate\Http\Response
     */
    public function edit(StockIn $stockIn)
    {
        if($stockIn->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('stockIn.edit', compact('stockIn'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockIn  $stockIn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockIn $stockIn)
    {
        
        if($stockIn->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|numeric|min:1',
        ]);
        $product = Product::findOrFail($request->product_id);
        $total_price = $product->price * $request->quantity;
        $data = $request->all();
        $data['total_price'] = $total_price;
        $stockIn->update($data);
         return view('stockIn.index')->with('success', 'Stock in transaction recorded successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockIn  $stockIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockIn $stockIn)
    {
        
        if($stockIn->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $stockIn->delete();
        return view('stockIn.index')->with('success', 'Stock In transaction deleted successfully!');
    }
}
