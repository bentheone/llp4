@extends('layout')
@section('title', 'Dashboard')
@section('content')
    @include('components.navbar')
    <div class="dashboard-container">
            <div class="greeting">
                <h1>Welcome, Mpano!</h1>
                <p>Here is your dashboard</p>
            </div>
        <div class="card-container">
            <div class="card">
                <h3>23</h3>
                <p>Products</p>
            </div>
            <div class="card">
                <h3>20</h3>
                <p>In</p>
            </div>
            <div class="card">
                <h3>0</h3>
                <p>Out</p>
            </div>
        </div>
    </div>
@endsection
