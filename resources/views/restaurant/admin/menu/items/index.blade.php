@extends('restaurant.admin.layouts.app')

@section('title', 'Menu Items')

@section('content')
@php use App\Enums\FoodType; @endphp
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Menu Items</li>
    </ol>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Items</h4>
                @can('menu.write')
                <a href="{{ route('admin.menu.items.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Add Item
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
                                <th>Category</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Available</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category?->name ?? '—' }}</td>
                                <td>₹{{ number_format((float) $item->price, 2) }}</td>
                                <td>
                                    @switch($item->food_type)
                                        @case(FoodType::Veg)
                                            <span class="badge bg-success">Veg</span>
                                            @break
                                        @case(FoodType::Egg)
                                            <span class="badge bg-warning text-dark">Eggetarian</span>
                                            @break
                                        @default
                                            <span class="badge bg-danger">Non-Veg</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($item->is_available)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @can('menu.write')
                                    <form action="{{ route('admin.menu.items.toggle-availability', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-info btn-sm">
                                            {{ $item->is_available ? 'Mark Unavailable' : 'Mark Available' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.menu.items.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.menu.items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No items found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
