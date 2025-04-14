<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = Auth::user();
        $products = $user->products()->get();
        // dd($products);
        return view('products.index', compact('products', 'user'));
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.index');
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
            'name'=>'required|string|max:255',
            'price'=> 'required|numeric|min:0',
            'category'=>'required|string|max:255'
            ]);

            $data['user_id'] = auth()->id();
            Product::create($data);
            return back()->with('success', 'Product created successfully');
        }catch(\Exception $e) {
            dd($e->getMessage());
            return back()->withErrors('product', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $product = $product->toArray();
        // dd($product);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403, 'Unauthorized!');
        }
        $request->validate([
            'name'=> 'required|string|max:255',
            'price'=> 'required|numeric|min:0',
        ]);

        $product->update($request->all());
        return redirect('/products')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403, 'Unauthorized!');
        }
        $product->delete();
        return to_route('products.index')->with('success', 'Product deleted successfully!');
    }
}
