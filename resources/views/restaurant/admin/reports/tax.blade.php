@extends('restaurant.admin.layouts.app')

@section('title', 'Tax Report')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Tax / GST Report</h4></div>
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
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Taxable Amount</small><h4>{{ number_format($totals['taxable_amount'], 2) }}</h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Tax Collected</small><h4>{{ number_format($totals['tax_collected'], 2) }}</h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Service Charge</small><h4>{{ number_format($totals['service_charge'], 2) }}</h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Grand Total</small><h4>{{ number_format($totals['grand_total'], 2) }}</h4></div></div></div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Paid At</th>
                    <th>Subtotal</th>
                    <th>Tax</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->paid_at?->format('d M Y') ?? '—' }}</td>
                    <td>{{ number_format((float) $order->subtotal, 2) }}</td>
                    <td>{{ number_format((float) $order->tax_amount, 2) }}</td>
                    <td>{{ number_format((float) $order->total_amount, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No orders in this period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
