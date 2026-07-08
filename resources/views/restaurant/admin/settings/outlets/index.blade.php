@extends('restaurant.admin.layouts.app')

@section('title', 'Outlets')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Outlets</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.settings.outlets.create') }}" class="btn btn-primary">Add Outlet</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Phone</th>
                    <th>Primary</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($outlets as $outlet)
                <tr>
                    <td>{{ $outlet->name }}</td>
                    <td>{{ $outlet->code ?? '—' }}</td>
                    <td>{{ $outlet->phone ?? '—' }}</td>
                    <td>{{ $outlet->is_primary ? 'Yes' : 'No' }}</td>
                    <td>{{ $outlet->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.settings.outlets.edit', $outlet->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.settings.outlets.destroy', $outlet->id) }}" class="d-inline" onsubmit="return confirm('Delete this outlet?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No outlets yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $outlets->links() }}
    </div>
</div>
@endsection
