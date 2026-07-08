@extends('restaurant.admin.layouts.app')

@section('title', 'Order History')

@section('content')
<div class="row page-titles">
    <div class="col">
        <h4 class="mb-0">Order History</h4>
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
                        <th>Total</th>
                        <th>Paid At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->type->label() }}</td>
                        <td>{{ $order->table?->name ?? '—' }}</td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ $order->paid_at?->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">No paid orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
</div>
@endsection
