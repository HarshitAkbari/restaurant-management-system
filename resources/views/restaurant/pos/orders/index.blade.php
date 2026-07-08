@extends('restaurant.pos.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Open Orders</h4>
    <a href="{{ route('pos.dashboard') }}" class="btn btn-primary">New Order</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Type</th>
                    <th>Table</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->type->label() }}</td>
                    <td>{{ $order->table?->name ?? '—' }}</td>
                    <td><span class="badge bg-info">{{ $order->status->label() }}</span></td>
                    <td>₹{{ number_format($order->total_amount, 2) }}</td>
                    <td><a href="{{ route('pos.orders.show', $order->id) }}" class="btn btn-sm btn-primary">Bill</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted p-4">No open orders.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
