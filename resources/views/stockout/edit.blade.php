@extends('layout')
@section('title', 'Edit Stock Out')
@section('content')
@include('components.navbar')
    <div class="header">
        <h1>Stock Outs</h1>
        <div class="user">
            <p class="bold">{{$user->names}}</p</b>
            <p>{{$user->email}}</p>
        </div>
    </div>
    <div class="edit-container">
        <div class="form-container">
            <h2>Edit Stock In</h2>
            @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form action="{{route('stockout.update', $stockout)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="product">Product</label>
                    <select name="product_id" id="product_id">
                            <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="0" required value="{{old('quantity', $stockout->quantity)}}">
                </div>
                <button type="submit">Remove product out</button>
            </form>
        </div>
    </div>
@endsection