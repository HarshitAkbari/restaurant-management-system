@extends('restaurant.admin.layouts.app')

@section('title', 'Add Menu Item')

@section('content')
@php use App\Enums\FoodType; @endphp
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.menu.items.index') }}">Items</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">New Menu Item</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.menu.items.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="menu_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="menu_category_id" id="menu_category_id" class="form-control @error('menu_category_id') is-invalid @enderror" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('menu_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('menu_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prep_time_minutes" class="form-label">Prep Time (minutes)</label>
                            <input type="number" name="prep_time_minutes" id="prep_time_minutes" min="0" class="form-control @error('prep_time_minutes') is-invalid @enderror" value="{{ old('prep_time_minutes') }}">
                            @error('prep_time_minutes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="kitchen_station" class="form-label">Kitchen Station</label>
                        <input type="text" name="kitchen_station" id="kitchen_station" class="form-control @error('kitchen_station') is-invalid @enderror" value="{{ old('kitchen_station') }}" placeholder="e.g. grill, tandoor, cold">
                        @error('kitchen_station')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @include('restaurant.admin.menu.items.partials.food-type-field', ['selected' => FoodType::Veg->value])
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check custom-checkbox">
                                <input type="checkbox" name="is_available" id="is_available" value="1" class="form-check-input" {{ old('is_available', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_available">Available</label>
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
                        <button type="submit" class="btn btn-primary">Save Item</button>
                        <a href="{{ route('admin.menu.items.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
