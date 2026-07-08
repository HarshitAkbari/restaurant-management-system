@extends('restaurant.admin.layouts.app')

@section('title', 'Stock Alerts')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Low Stock Alerts</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Current Stock</th>
                    <th>Reorder Level</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                <tr class="table-warning">
                    <td>{{ $material->name }}</td>
                    <td>{{ number_format((float) $material->current_stock, 3) }}</td>
                    <td>{{ number_format((float) $material->reorder_level, 3) }}</td>
                    <td>{{ $material->unit }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">All materials are above reorder level.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
