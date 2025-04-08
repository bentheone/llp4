<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockOuts = StockOut::all();
        return view('stockOut.index', compact('stockOuts'));
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

            $request->validate([
                'product_id'=>'required|exists:products,id',
                'quantity'=>'required|integer|min:1'
            ]);
            $product = Product::findOrFail($request->product_id);
            $total_price = $product->price * $request->quantity;
            $data = $request->all();
            $data['total_price'] = $total_price;
            StockOut::create($data);

        }catch(\Exception $e) {

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
    public function edit(StockOut $stockOut)
    {
        if($stockOut->user_id !== auth()->id()) {
            abort(403, 'Unauthorized!');
        }
        return view('stockOut.edit', compact('stockOut'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockOut  $stockOut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockOut $stockOut)
    {
        if($stockOut->user_id !== auth()->id()) {
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

        $product->update($data);
        return view('stockOuts.index')->with('success', 'Stock Out Transaction aupdated successfully!');
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
