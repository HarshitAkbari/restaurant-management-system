@extends('restaurant.admin.layouts.app')

@section('title', 'Suppliers')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Suppliers</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.inventory.suppliers.create') }}" class="btn btn-primary">Add Supplier</a>
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
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->phone ?? '—' }}</td>
                    <td>{{ $supplier->email ?? '—' }}</td>
                    <td>{{ $supplier->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.inventory.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No suppliers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
