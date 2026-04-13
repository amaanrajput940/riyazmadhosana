@extends('layouts.portal.app')

@section('title','View Order')

@section('content')
<div class="container">
    <h4>Order #{{ $order->order_number }}</h4>

    <p><strong>Customer:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>
    <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->postal_code }}</p>
    <p><strong>Total:</strong> ${{ $order->total }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Payment:</strong> {{ ucfirst($order->payment_status) }}</p>

    <a href="{{ route('dashboard.orders.list') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection
