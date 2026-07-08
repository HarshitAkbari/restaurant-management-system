@extends('restaurant.admin.layouts.app')

@section('title', 'Edit Combo')

@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.menu.combos.index') }}">Combos</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Combo</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.menu.combos.update', $combo) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $combo->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $combo->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $combo->price) }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="item_ids" class="form-label">Included Items</label>
                        <select name="item_ids[]" id="item_ids" class="form-control @error('item_ids') is-invalid @enderror" multiple size="8">
                            @php
                                $selectedIds = old('item_ids', $combo->items->pluck('id')->all());
                            @endphp
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ in_array($item->id, $selectedIds) ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple items.</small>
                        @error('item_ids')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        @error('item_ids.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check custom-checkbox">
                            <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" {{ old('is_active', $combo->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Combo</button>
                        <a href="{{ route('admin.menu.combos.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
