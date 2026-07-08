@extends('restaurant.admin.layouts.app')

@section('title', 'Menu Combos')

@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Combos</li>
    </ol>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Combos</h4>
                @can('menu.write')
                <a href="{{ route('admin.menu.combos.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Add Combo
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
                                <th>Items</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($combos as $combo)
                            <tr>
                                <td>{{ $combo->id }}</td>
                                <td>{{ $combo->name }}</td>
                                <td>₹{{ number_format((float) $combo->price, 2) }}</td>
                                <td>
                                    @if($combo->items->isNotEmpty())
                                        {{ $combo->items->pluck('name')->join(', ') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($combo->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @can('menu.write')
                                    <a href="{{ route('admin.menu.combos.edit', $combo) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.menu.combos.destroy', $combo) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this combo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No combos found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $combos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
