@extends('restaurant.admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row page-titles">
    <div class="col">
        <h4 class="mb-0">Dashboard</h4>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Today's Sales</h5>
                <h2 class="mb-0">₹{{ number_format($stats['today_sales'], 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Open Orders</h5>
                <h2 class="mb-0">{{ $stats['open_orders_count'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Occupied Tables</h5>
                <h2 class="mb-0">{{ $stats['occupied_tables_count'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Quick Links</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary me-2">Live Orders</a>
                <a href="{{ route('admin.tables.index') }}" class="btn btn-outline-primary me-2">Tables</a>
                <a href="{{ route('pos.dashboard') }}" class="btn btn-outline-success">Open POS</a>
            </div>
        </div>
    </div>
</div>
@endsection
