@extends('restaurant.admin.layouts.app')

@section('title', 'Inventory Report')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Inventory Report</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>SKU</th>
                    <th>Unit</th>
                    <th>Current Stock</th>
                    <th>Reorder Level</th>
                    <th>Cost/Unit</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                <tr class="{{ $material->current_stock <= $material->reorder_level ? 'table-warning' : '' }}">
                    <td>{{ $material->name }}</td>
                    <td>{{ $material->sku ?? '—' }}</td>
                    <td>{{ $material->unit }}</td>
                    <td>{{ number_format((float) $material->current_stock, 3) }}</td>
                    <td>{{ number_format((float) $material->reorder_level, 3) }}</td>
                    <td>{{ number_format((float) $material->cost_per_unit, 2) }}</td>
                    <td>{{ $material->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">No raw materials found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
