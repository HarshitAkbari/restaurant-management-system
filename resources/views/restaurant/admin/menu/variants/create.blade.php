@extends('restaurant.admin.layouts.app')

@section('title', 'Add Variant')

@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.menu.variants.index') }}">Variants</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">New Variant</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.menu.variants.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="menu_item_id" class="form-label">Menu Item <span class="text-danger">*</span></label>
                        <select name="menu_item_id" id="menu_item_id" class="form-control @error('menu_item_id') is-invalid @enderror" required>
                            <option value="">Select item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ old('menu_item_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('menu_item_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Variant Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Small, Large" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check custom-checkbox">
                                <input type="checkbox" name="is_default" id="is_default" value="1" class="form-check-input" {{ old('is_default') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_default">Default Variant</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check custom-checkbox">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Variant</button>
                        <a href="{{ route('admin.menu.variants.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
