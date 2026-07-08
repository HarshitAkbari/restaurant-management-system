@extends('restaurant.admin.layouts.app')

@section('title', 'Edit Raw Material')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Edit Raw Material</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.materials.update', $material->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $material->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $material->sku) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Unit</label>
                    <input type="text" name="unit" class="form-control" value="{{ old('unit', $material->unit) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cost per Unit</label>
                    <input type="number" step="0.01" name="cost_per_unit" class="form-control" value="{{ old('cost_per_unit', $material->cost_per_unit) }}" min="0">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Current Stock</label>
                    <input type="number" step="0.001" name="current_stock" class="form-control" value="{{ old('current_stock', $material->current_stock) }}" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Reorder Level</label>
                    <input type="number" step="0.001" name="reorder_level" class="form-control" value="{{ old('reorder_level', $material->reorder_level) }}" min="0">
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $material->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.inventory.materials.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
