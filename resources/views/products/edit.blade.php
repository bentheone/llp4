@extends('layout')
@section('title', 'Edit Product')
@section('content')
    @include('components.navbar')
    <div class="edit-container">
    <div class="form-container">
        <h2>Edit Product</h2>
        @if ($errors->any())
            <ul class="errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="{{route('products.update', $product['id'])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{old('name', $product['name'])}}" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" value="{{old('price', $product['price'])}}" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" value="{{old('category', $product['category'])}}" required>
            </div>
            <button type="submit"> Edit Product</button>
        </form>
    </div>
</div>
@endsection