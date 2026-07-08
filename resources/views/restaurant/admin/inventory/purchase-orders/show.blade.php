@extends('restaurant.admin.layouts.app')

@section('title', 'Purchase Order ' . $purchaseOrder->po_number)

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">PO {{ $purchaseOrder->po_number }}</h4></div>
    <div class="col-auto">
        @if($purchaseOrder->status !== 'received')
        <form method="POST" action="{{ route('admin.inventory.purchase-orders.receive', $purchaseOrder->id) }}" class="d-inline" onsubmit="return confirm('Receive this PO and add stock?')">
            @csrf
            <button class="btn btn-success">Receive PO</button>
        </form>
        @endif
        <a href="{{ route('admin.inventory.purchase-orders.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier?->name }}</p>
                <p><strong>Status:</strong> {{ ucfirst($purchaseOrder->status) }}</p>
                <p><strong>Ordered:</strong> {{ $purchaseOrder->ordered_at?->format('d M Y') ?? '—' }}</p>
                <p><strong>Received:</strong> {{ $purchaseOrder->received_at?->format('d M Y') ?? '—' }}</p>
                <p><strong>Total:</strong> {{ number_format((float) $purchaseOrder->total_amount, 2) }}</p>
                @if($purchaseOrder->notes)
                <p><strong>Notes:</strong> {{ $purchaseOrder->notes }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Line Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrder->items as $item)
                        <tr>
                            <td>{{ $item->rawMaterial?->name ?? '—' }}</td>
                            <td>{{ number_format((float) $item->quantity, 3) }}</td>
                            <td>{{ number_format((float) $item->unit_cost, 2) }}</td>
                            <td>{{ number_format((float) $item->line_total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
