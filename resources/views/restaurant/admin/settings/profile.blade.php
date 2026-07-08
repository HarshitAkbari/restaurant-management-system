@extends('restaurant.admin.layouts.app')

@section('title', 'Restaurant Profile')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Restaurant Profile</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.profile.update') }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Display Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $setting->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Legal Name</label>
                    <input type="text" name="legal_name" class="form-control" value="{{ old('legal_name', $setting->legal_name) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $setting->phone) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $setting->address) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">GSTIN</label>
                    <input type="text" name="gstin" class="form-control" value="{{ old('gstin', $setting->gstin) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Currency</label>
                    <input type="text" name="currency" class="form-control" value="{{ old('currency', $setting->currency) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Timezone</label>
                    <input type="text" name="timezone" class="form-control" value="{{ old('timezone', $setting->timezone) }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Profile</button>
        </form>
    </div>
</div>
@endsection
