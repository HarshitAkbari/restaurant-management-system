@extends('restaurant.admin.layouts.app')

@section('title', 'Edit Table')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Edit Table</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.tables.update', $table->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Area</label>
                <select name="area_id" class="form-select" required>
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}" @selected(old('area_id', $table->area_id) == $area->id)>{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $table->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Code</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $table->code) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $table->capacity) }}" min="1">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Pos X</label>
                    <input type="number" name="pos_x" class="form-control" value="{{ old('pos_x', $table->pos_x) }}" min="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Pos Y</label>
                    <input type="number" name="pos_y" class="form-control" value="{{ old('pos_y', $table->pos_y) }}" min="0">
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $table->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
