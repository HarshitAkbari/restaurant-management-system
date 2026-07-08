@extends('restaurant.admin.layouts.app')

@section('title', 'Tax Settings')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Tax Settings</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.tax.update') }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">CGST %</label>
                    <input type="number" step="0.01" name="cgst_percent" class="form-control" value="{{ old('cgst_percent', $setting->cgst_percent) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">SGST %</label>
                    <input type="number" step="0.01" name="sgst_percent" class="form-control" value="{{ old('sgst_percent', $setting->sgst_percent) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Service Charge %</label>
                    <input type="number" step="0.01" name="service_charge_percent" class="form-control" value="{{ old('service_charge_percent', $setting->service_charge_percent) }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Tax Settings</button>
        </form>
    </div>
</div>
@endsection
