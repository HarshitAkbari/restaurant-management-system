@extends('restaurant.admin.layouts.app')

@section('title', 'Customers')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Customers</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">Add Customer</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-8">
                <input type="text" name="q" class="form-control" placeholder="Search by name, phone, or email" value="{{ $search }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Search</button>
                @if($search)
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Loyalty Points</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone ?? '—' }}</td>
                    <td>{{ $customer->email ?? '—' }}</td>
                    <td>{{ $customer->loyalty_points }}</td>
                    <td>{{ $customer->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $customers->appends(['q' => $search])->links() }}
    </div>
</div>
@endsection
