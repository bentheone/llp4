@extends('layout')
@section('title', 'Edit Product')
@section('content')
    @include('components.navbar')
    <div class="form-container">
        <h2>Edit Product</h2>
        @if ($errors->any())
            <ul class="errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection