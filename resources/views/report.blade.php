@extends('layout')
@section('title', 'Daily Report')
@section('content')
    @include('components.navbar')
    <h2>Generate a daily report</h2>
    <div class="report-page">
        <div class="form-container">
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
            <form action="/report" method="POST">
                @csrf
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" required>
                </div>
                <button type="submit">Get report</button>
            </form>
        </div>
    </div>
    @if (isset($reportData))
        <h2>Report for {{request('date')}}</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock In Qty</th>
                        <th>Stock In Amount</th>
                        <th>Stock Out Qty</th>
                        <th>Stock Out Amount</th>
                        <th>Defference</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reportData as $data)
                        <tr>
                            <td>{{$data['product_name']}}</td>
                            <td>{{$data['stock_in_qty']}}</td>
                            <td>${{number_format($data['stock_in_amount'],2)}}</td>
                            <td>{{$data['stock_out_qty']}}</td>
                            <td>${{number_format($data['stock_out_amount'], 2)}}</td>
                            <td>{{number_format($data['amount_difference'])}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No reocords for this date</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
@endsection