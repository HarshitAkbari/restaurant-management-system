@extends('restaurant.admin.layouts.app')

@section('title', $customer->name)

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">{{ $customer->name }}</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Phone:</strong> {{ $customer->phone ?? '—' }}</p>
                <p><strong>Email:</strong> {{ $customer->email ?? '—' }}</p>
                <p><strong>Loyalty Points:</strong> {{ $customer->loyalty_points }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Status:</strong> {{ $customer->is_active ? 'Active' : 'Inactive' }}</p>
                <p><strong>Total Orders:</strong> {{ $customer->orders_count ?? 0 }}</p>
                @if($customer->notes)
                <p><strong>Notes:</strong> {{ $customer->notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
