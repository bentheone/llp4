@extends('layout')
@section('title', 'Products')
@section('content')
    @include('components.navbar')
    <div class="header">
        <h1>Products</h1>
        <div class="user">
            <p class="bold">{{$user->names}}</p</b>
            <p>{{$user->email}}</p>
        </div>
    </div>

    <div class="resource-main">
        <div class="table-container">
            @if ($products->count() == 0)
                <p>No products yet!</p>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->category }}</td>
                            <td class="actions">
                                <div class="actions">
                                    <p><a href="{{route('products.edit', $product->id)}} ">Edit</a></p>
                                    <p>
                                        <form action="{{route('products.destroy', $product->id)}}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                        </form>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
                
            @endif
        </div>
        <div class="form-container">
            <h2>Create New Product</h2>
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
            <form action="{{route('products.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Unit Price</label>
                    <input type="number" name="price" id="price" min="0"  required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" name="category" id="category" required>
                </div>
                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>
    
@endsection
