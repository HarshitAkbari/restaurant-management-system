@extends('restaurant.admin.layouts.app')

@section('title', 'Live Orders')

@section('content')
<div class="row page-titles">
    <div class="col">
        <h4 class="mb-0">Live Orders</h4>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Type</th>
                        <th>Table</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Created</th>
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
                        <td>{{ $order->created_at?->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted">No live orders.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
