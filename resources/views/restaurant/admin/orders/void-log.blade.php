@extends('restaurant.admin.layouts.app')

@section('title', 'Void Log')

@section('content')
<div class="row page-titles">
    <div class="col">
        <h4 class="mb-0">Void / Cancel Log</h4>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Table</th>
                        <th>Reason</th>
                        <th>Voided At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->table?->name ?? '—' }}</td>
                        <td>{{ $order->void_reason }}</td>
                        <td>{{ $order->voided_at?->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">No voided orders.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
</div>
@endsection
