@extends('restaurant.admin.layouts.app')

@section('title', 'Add Table')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Add Table</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.tables.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Area</label>
                <select name="area_id" class="form-select @error('area_id') is-invalid @enderror" required>
                    <option value="">Select area</option>
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}" @selected(old('area_id') == $area->id)>{{ $area->name }}</option>
                    @endforeach
                </select>
                @error('area_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Code</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', 2) }}" min="1">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Pos X</label>
                    <input type="number" name="pos_x" class="form-control" value="{{ old('pos_x', 0) }}" min="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Pos Y</label>
                    <input type="number" name="pos_y" class="form-control" value="{{ old('pos_y', 0) }}" min="0">
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
