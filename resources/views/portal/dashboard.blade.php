@extends('layouts.portal.app')

@section('title', 'Dashboard')

@section('content')

@php

   $totalUsers = DB::table('users')
    ->where(function ($query) {
        $query->where('role_id', '!=', '1');
    })
    ->count();

$monthlyRevenue = DB::table('orders')
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->where(function ($query) {
            $query->where('payment_status', 'paid')
                  ->orWhere('status', 'delivered');
        })
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'month')
        ->toArray();

    // 12 months default 0
    $monthlyRevenueData = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlyRevenueData[] = $monthlyRevenue[$i] ?? 0;
    }

    $totalProducts = DB::table('products')
    ->where(function ($query) {
        $query->where('is_active', 1);
    })
    ->count();

    $totalOrders = DB::table('orders')
    ->where(function ($query) {
        $query->where('status', 'pending');
    })
    ->count();

    $totalRevenue = DB::table('orders')
    ->where(function ($query) {
        $query->where('payment_status', 'paid')
              ->orWhere('status', 'delivered');
    })
    ->sum('total');
@endphp


<h2 class="mb-4">Dashboard Overview</h2>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Total Users</h5>
                <h3>{{$totalUsers}}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Total Products</h5>
                <h3>{{$totalProducts}}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Total Orders</h5>
                <h3>{{$totalOrders}}</h3>
            </div>
        </div>
    </div>

     <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Total Revenue</h5>
                <h3>RS {{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <canvas id="revenueChart" height="100"></canvas>
</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function () {

    const revenueData = @json($monthlyRevenueData);

    const ctx = document.getElementById('revenueChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Jan','Feb','Mar','Apr','May','Jun',
                'Jul','Aug','Sep','Oct','Nov','Dec'
            ],
            datasets: [{
                label: 'Monthly Revenue ({{ date("Y") }})',
                data: revenueData,
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

});
</script>
@endpush
