@extends('restaurant.admin.layouts.app')

@section('title', 'Online Order #' . $onlineOrder->id)

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Online Order #{{ $onlineOrder->id }}</h4></div>
    <div class="col-auto">
        @if($onlineOrder->status === \App\Enums\OnlineOrderStatus::Pending)
        <form method="POST" action="{{ route('admin.online-orders.accept', $onlineOrder->id) }}" class="d-inline">
            @csrf
            <button class="btn btn-success">Accept</button>
        </form>
        <form method="POST" action="{{ route('admin.online-orders.reject', $onlineOrder->id) }}" class="d-inline" onsubmit="return confirm('Reject this order?')">
            @csrf
            <button class="btn btn-danger">Reject</button>
        </form>
        @endif
        <a href="{{ route('admin.online-orders.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Status:</strong> {{ $onlineOrder->status->label() }}</p>
                <p><strong>Channel:</strong> {{ ucfirst($onlineOrder->channel) }}</p>
                <p><strong>Customer:</strong> {{ $onlineOrder->customer_name ?? '—' }}</p>
                <p><strong>Phone:</strong> {{ $onlineOrder->customer_phone ?? '—' }}</p>
                <p><strong>Total:</strong> {{ number_format((float) $onlineOrder->total_amount, 2) }}</p>
                @if($onlineOrder->order_id)
                <p><strong>Internal Order:</strong> #{{ $onlineOrder->order_id }}</p>
                @endif
                @if($onlineOrder->notes)
                <p><strong>Notes:</strong> {{ $onlineOrder->notes }}</p>
                @endif
            </div>
        </div>
        @if($onlineOrder->status !== \App\Enums\OnlineOrderStatus::Pending && $onlineOrder->status !== \App\Enums\OnlineOrderStatus::Rejected)
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.online-orders.update-status', $onlineOrder->id) }}">
                    @csrf
                    @method('PUT')
                    <label class="form-label">Update Status</label>
                    <div class="input-group">
                        <select name="status" class="form-select">
                            @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ $onlineOrder->status === $status ? 'selected' : '' }}>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">Items</div>
            <div class="card-body">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($onlineOrder->items ?? [] as $item)
                        <tr>
                            <td>{{ $item['name'] ?? '—' }}</td>
                            <td>{{ $item['quantity'] ?? 1 }}</td>
                            <td>{{ number_format((float) ($item['price'] ?? 0), 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-muted">No items.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
