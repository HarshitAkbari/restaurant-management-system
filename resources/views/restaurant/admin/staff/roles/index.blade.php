@extends('restaurant.admin.layouts.app')

@section('title', 'Roles & Permissions')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Roles & Permissions</h4></div>
</div>

@foreach($roles as $role)
<div class="card mb-3">
    <div class="card-header"><strong>{{ ucfirst($role->name) }}</strong></div>
    <div class="card-body">
        @if($role->permissions->isEmpty())
        <p class="text-muted mb-0">No permissions assigned.</p>
        @else
        <div class="d-flex flex-wrap gap-2">
            @foreach($role->permissions as $permission)
            <span class="badge bg-primary">{{ $permission->name }}</span>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endforeach
@endsection
