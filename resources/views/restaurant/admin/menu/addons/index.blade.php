@extends('restaurant.admin.layouts.app')

@section('title', 'Menu Add-ons')

@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Add-ons</li>
    </ol>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Add-ons</h4>
                @can('menu.write')
                <a href="{{ route('admin.menu.addons.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Add Add-on
                </a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($addons as $addon)
                            <tr>
                                <td>{{ $addon->id }}</td>
                                <td>{{ $addon->name }}</td>
                                <td>₹{{ number_format((float) $addon->price, 2) }}</td>
                                <td>
                                    @if($addon->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @can('menu.write')
                                    <a href="{{ route('admin.menu.addons.edit', $addon) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.menu.addons.destroy', $addon) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this add-on?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No add-ons found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $addons->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
