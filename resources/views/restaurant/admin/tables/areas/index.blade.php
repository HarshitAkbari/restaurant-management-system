@extends('restaurant.admin.layouts.app')

@section('title', 'Areas')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Areas</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.tables.areas.create') }}" class="btn btn-primary">Add Area</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Sort Order</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($areas as $area)
                <tr>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->sort_order }}</td>
                    <td>{{ $area->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.tables.areas.edit', $area->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.tables.areas.destroy', $area->id) }}" class="d-inline" onsubmit="return confirm('Delete this area?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">No areas yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $areas->links() }}
    </div>
</div>
@endsection
