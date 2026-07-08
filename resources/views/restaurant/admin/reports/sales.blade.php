@extends('restaurant.admin.layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Sales Report</h4></div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">From</label>
                <input type="date" name="from" class="form-control" value="{{ $from }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">To</label>
                <input type="date" name="to" class="form-control" value="{{ $to }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Orders</small><h4>{{ $totals['count'] }}</h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Subtotal</small><h4>{{ number_format($totals['subtotal'], 2) }}</h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Tax</small><h4>{{ number_format($totals['tax'], 2) }}</h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Total</small><h4>{{ number_format($totals['total'], 2) }}</h4></div></div></div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Staff</th>
                    <th>Paid At</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer?->name ?? 'Walk-in' }}</td>
                    <td>{{ $order->creator?->name ?? '—' }}</td>
                    <td>{{ $order->paid_at?->format('d M Y H:i') ?? '—' }}</td>
                    <td>{{ number_format((float) $order->total_amount, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No paid orders in this period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
