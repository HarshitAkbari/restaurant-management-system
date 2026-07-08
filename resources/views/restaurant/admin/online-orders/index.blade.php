@extends('restaurant.admin.layouts.app')

@section('title', 'Online Orders')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Online Orders @if($pendingCount > 0)<span class="badge bg-warning">{{ $pendingCount }} pending</span>@endif</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Channel</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ ucfirst($order->channel) }}</td>
                    <td>{{ $order->customer_name ?? '—' }}</td>
                    <td>{{ $order->customer_phone ?? '—' }}</td>
                    <td><span class="badge bg-secondary">{{ $order->status->label() }}</span></td>
                    <td>{{ number_format((float) $order->total_amount, 2) }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.online-orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No online orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
</div>
@endsection
