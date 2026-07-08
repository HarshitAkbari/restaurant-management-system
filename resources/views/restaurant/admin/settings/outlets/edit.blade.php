@extends('restaurant.admin.layouts.app')

@section('title', 'Edit Outlet')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Edit Outlet</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.outlets.update', $outlet->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $outlet->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Code</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $outlet->code) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $outlet->phone) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $outlet->address) }}</textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $outlet->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_primary" value="1" class="form-check-input" id="is_primary" {{ old('is_primary', $outlet->is_primary) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_primary">Primary outlet</label>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.settings.outlets.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
