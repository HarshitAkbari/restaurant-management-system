@extends('restaurant.admin.layouts.app')

@section('title', 'Expense Categories')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Expense Categories</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.expenses.categories.create') }}" class="btn btn-primary">Add Category</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.expenses.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
</div>
@endsection
