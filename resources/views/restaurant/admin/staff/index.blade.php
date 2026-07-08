@extends('restaurant.admin.layouts.app')

@section('title', 'Staff')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Employees</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">Add Employee</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone ?? '—' }}</td>
                    <td>{{ $member->roles->first()?->name ?? '—' }}</td>
                    <td>{{ $member->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.staff.edit', $member->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        @if($member->is_active)
                        <form method="POST" action="{{ route('admin.staff.deactivate', $member->id) }}" class="d-inline" onsubmit="return confirm('Deactivate this employee?')">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-sm btn-warning">Deactivate</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No staff members yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $staff->links() }}
    </div>
</div>
@endsection
