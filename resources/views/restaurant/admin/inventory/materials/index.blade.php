@extends('restaurant.admin.layouts.app')

@section('title', 'Raw Materials')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Raw Materials</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.inventory.materials.create') }}" class="btn btn-primary">Add Material</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Unit</th>
                    <th>Stock</th>
                    <th>Reorder Level</th>
                    <th>Cost/Unit</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                <tr>
                    <td>{{ $material->name }}</td>
                    <td>{{ $material->sku ?? '—' }}</td>
                    <td>{{ $material->unit }}</td>
                    <td>{{ number_format((float) $material->current_stock, 3) }}</td>
                    <td>{{ number_format((float) $material->reorder_level, 3) }}</td>
                    <td>{{ number_format((float) $material->cost_per_unit, 2) }}</td>
                    <td>{{ $material->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.inventory.materials.edit', $material->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No raw materials yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $materials->links() }}
    </div>
</div>
@endsection
