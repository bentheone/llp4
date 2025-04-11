@extends('layout')
@section('title', 'Stock Out')
@section('content')
    @include('components.navbar')
    <div class="header">
        <h1>Stock Outs</h1>
        <div class="user">
            <p class="bold">{{$user->names}}</p</b>
            <p>{{$user->email}}</p>
        </div>
    </div>

    <div class="resource-main">
        <div class="table-container">
            @if ($stockOuts->count() == 0)
                <p>No stock outs yet!</p>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total Price</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockOuts as $stockOut)
                        <tr>
                            <td>{{ $stockOut->product->name }}</td>
                            <td>{{ $stockOut->total_price }}</td>
                            <td>{{ $stockOut->quantity }}</td>
                            <td>{{ $stockOut->created_at }}</td>
                            <td class="actions">
                                <div class="actions">
                                    <p><a href="">Edit</a></p>
                                    <p><a href="">Delete</a></p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
                
            @endif
        </div>
        <div class="form-container">
            <h2>Remove product from stock</h2>
            @if (session('success'))
                <div class="success">
                    {{session('success')}}
                </div>
                
            @endif
            @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
            <form action="{{route('stockout.store')}}" method="POST">
                @csrf
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
                    <input type="number" name="quantity" id="quantity" min="0" required>
                </div>
                <button type="submit">Remove product(s)</button>
            </form>
        </div>
    </div>
    
@endsection
