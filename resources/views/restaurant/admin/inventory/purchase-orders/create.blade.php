@extends('restaurant.admin.layouts.app')

@section('title', 'Create Purchase Order')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Create Purchase Order</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.purchase-orders.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                        <option value="">Select supplier</option>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ordered Date</label>
                    <input type="date" name="ordered_at" class="form-control" value="{{ old('ordered_at', date('Y-m-d')) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            <h5 class="mb-3">Line Items</h5>
            @for($i = 0; $i < 5; $i++)
            <div class="row mb-2">
                <div class="col-md-5">
                    <select name="items[{{ $i }}][raw_material_id]" class="form-select">
                        <option value="">Raw material</option>
                        @foreach($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.001" name="items[{{ $i }}][quantity]" class="form-control" placeholder="Qty" min="0">
                </div>
                <div class="col-md-4">
                    <input type="number" step="0.01" name="items[{{ $i }}][unit_cost]" class="form-control" placeholder="Unit cost" min="0">
                </div>
            </div>
            @endfor
            <button type="submit" class="btn btn-primary mt-3">Create PO</button>
            <a href="{{ route('admin.inventory.purchase-orders.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
@endsection
