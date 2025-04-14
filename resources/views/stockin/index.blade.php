@extends('layout')
@section('title', 'Stock In')
@section('content')
    @include('components.navbar')
    <div class="header">
        <h1>Stock Ins</h1>
        <div class="user">
            <p class="bold">{{$user->names}}</p</b>
            <p>{{$user->email}}</p>
        </div>
    </div>

    <div class="resource-main">
        <div class="table-container">
            @if ($stockIns->count() == 0)
                <p>No stock ins yet!</p>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total Price</th>
                        <th>Quantity</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockIns as $stockIn)
                        <tr>
                            <td>{{ $stockIn->product->name }}</td>
                            <td>{{ $stockIn->total_price }}</td>
                            <td>{{ $stockIn->quantity }}</td>
                            <td>{{ $stockIn->supplier_name }}</td>
                            <td>{{ $stockIn->created_at }}</td>
                            <td class="actions">
                                <p>
                                    <a href="{{route('stockin.edit', $stockIn->id)}} ">Edit</a></p>
                                <p>
                                        <form action="{{route('stockin.destroy', $stockIn->id)}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete" onclick="return confirm('Are you sure you want to delete this stockin?')">Delete</button>
                                        </form>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
                
            @endif
        </div>
        <div class="form-container">
            <h2>Add product to stock</h2>
            @if (session('success'))
                <div class="success">
                    {{session('success')}}
                </div>
                
            @endif
            @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
            <form action="{{route('stockin.store')}}" method="POST">
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
                <div class="form-group">
                    <label for="supplier">Supplier</label>
                    <input type="text" name="supplier_name" id="supplier_name" required>
                </div>
                <button type="submit">Add product In</button>
            </form>
        </div>
    </div>
    
@endsection
