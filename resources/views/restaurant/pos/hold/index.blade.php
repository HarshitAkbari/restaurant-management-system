@extends('restaurant.pos.layouts.app')

@section('title', 'Held Orders')

@section('content')
<h4 class="mb-3">Held Orders</h4>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Table</th>
                    <th>Total</th>
                    <th>Held At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->table?->name ?? '—' }}</td>
                    <td>₹{{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->held_at?->format('d M H:i') }}</td>
                    <td>
                        <form method="POST" action="{{ route('pos.orders.resume', $order->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-primary">Resume</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted p-4">No held orders.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
