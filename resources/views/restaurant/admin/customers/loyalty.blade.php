@extends('restaurant.admin.layouts.app')

@section('title', 'Loyalty Settings')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Loyalty Settings</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.customers.loyalty.update') }}">
            @csrf
            @method('PUT')
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_enabled" value="1" class="form-check-input" id="is_enabled" {{ old('is_enabled', $setting->is_enabled) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_enabled">Enable loyalty program</label>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Points per Rupee spent</label>
                    <input type="number" step="0.0001" name="points_per_rupee" class="form-control" value="{{ old('points_per_rupee', $setting->points_per_rupee) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Rupee value per point</label>
                    <input type="number" step="0.0001" name="rupee_per_point" class="form-control" value="{{ old('rupee_per_point', $setting->rupee_per_point) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Minimum redeem points</label>
                    <input type="number" name="min_redeem_points" class="form-control" value="{{ old('min_redeem_points', $setting->min_redeem_points) }}" min="0" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</div>
@endsection
