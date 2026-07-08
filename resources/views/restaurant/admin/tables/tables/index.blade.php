@extends('restaurant.admin.layouts.app')

@section('title', 'Tables')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Tables</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.tables.create') }}" class="btn btn-primary">Add Table</a>
        <a href="{{ route('admin.tables.layout') }}" class="btn btn-outline-primary">Layout</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Area</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($tables as $table)
                <tr>
                    <td>{{ $table->name }} @if($table->code)<small class="text-muted">({{ $table->code }})</small>@endif</td>
                    <td>{{ $table->area?->name ?? '—' }}</td>
                    <td>{{ $table->capacity }}</td>
                    <td><span class="badge bg-secondary">{{ $table->status->label() }}</span></td>
                    <td>{{ $table->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.tables.edit', $table->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.tables.destroy', $table->id) }}" class="d-inline" onsubmit="return confirm('Delete this table?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No tables yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $tables->links() }}
    </div>
</div>
@endsection
