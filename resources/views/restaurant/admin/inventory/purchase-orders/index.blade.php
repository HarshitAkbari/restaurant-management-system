@extends('restaurant.admin.layouts.app')

@section('title', 'Purchase Orders')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Purchase Orders</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.inventory.purchase-orders.create') }}" class="btn btn-primary">Create PO</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>PO Number</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Ordered</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchaseOrders as $po)
                <tr>
                    <td>{{ $po->po_number }}</td>
                    <td>{{ $po->supplier?->name ?? '—' }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($po->status) }}</span></td>
                    <td>{{ number_format((float) $po->total_amount, 2) }}</td>
                    <td>{{ $po->ordered_at?->format('d M Y') ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.inventory.purchase-orders.show', $po->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No purchase orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $purchaseOrders->links() }}
    </div>
</div>
@endsection
