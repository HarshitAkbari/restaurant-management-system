@extends('restaurant.admin.layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="row page-titles">
    <div class="col">
        <h4 class="mb-0">Order {{ $order->order_number }}</h4>
        <small class="text-muted">{{ $order->status->label() }} · {{ $order->type->label() }}</small>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Items</h5></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                {{ $item->name }}
                                @if($item->notes)<br><small class="text-muted">{{ $item->notes }}</small>@endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->unit_price, 2) }}</td>
                            <td>₹{{ number_format($item->line_total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <p class="mb-1">Table: <strong>{{ $order->table?->name ?? '—' }}</strong></p>
                <p class="mb-1">Guests: {{ $order->guest_count }}</p>
                <hr>
                <p class="mb-1 d-flex justify-content-between"><span>Subtotal</span><span>₹{{ number_format($order->subtotal, 2) }}</span></p>
                <p class="mb-1 d-flex justify-content-between"><span>Tax</span><span>₹{{ number_format($order->tax_amount, 2) }}</span></p>
                <p class="mb-1 d-flex justify-content-between"><span>Service Charge</span><span>₹{{ number_format($order->service_charge, 2) }}</span></p>
                <p class="mb-0 d-flex justify-content-between fw-bold"><span>Total</span><span>₹{{ number_format($order->total_amount, 2) }}</span></p>
            </div>
        </div>

        @if($order->status->isActive())
        @can('orders.void')
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Void Order</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.void', $order->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <textarea name="void_reason" class="form-control" rows="3" required>{{ old('void_reason') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Void this order?')">Void Order</button>
                </form>
            </div>
        </div>
        @endcan
        @endif
    </div>
</div>
@endsection
