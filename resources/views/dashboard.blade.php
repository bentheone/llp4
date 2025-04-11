@extends('layout')
@section('title', 'Dashboard')
@section('content')
    @include('components.navbar')
    <div class="dashboard-container">
            <div class="greeting">
                <h1>Welcome,{{$user->names}}!</h1>
                <p>Here is your dashboard</p>
            </div>
        <div class="card-container">
            <div class="card">
                <h3>{{$productCount}}</h3>
                <p>Products</p>
            </div>
            <div class="card">
                <h3>{{$stockInCount}}</h3>
                <p>In</p>
            </div>
            <div class="card">
                <h3>{{$stockOutCount}}</h3>
                <p>Out</p>
            </div>
        </div>
    </div>
@endsection
