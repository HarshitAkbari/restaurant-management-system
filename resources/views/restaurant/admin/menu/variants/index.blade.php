@extends('restaurant.admin.layouts.app')

@section('title', 'Menu Variants')

@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Variants</li>
    </ol>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Variants</h4>
                @can('menu.write')
                <a href="{{ route('admin.menu.variants.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Add Variant
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
                                <th>Item</th>
                                <th>Price</th>
                                <th>Default</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($variants as $variant)
                            <tr>
                                <td>{{ $variant->id }}</td>
                                <td>{{ $variant->name }}</td>
                                <td>{{ $variant->menuItem?->name ?? '—' }}</td>
                                <td>₹{{ number_format((float) $variant->price, 2) }}</td>
                                <td>
                                    @if($variant->is_default)
                                        <span class="badge bg-primary">Default</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($variant->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @can('menu.write')
                                    <a href="{{ route('admin.menu.variants.edit', $variant) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.menu.variants.destroy', $variant) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this variant?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No variants found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $variants->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
