@extends('restaurant.admin.layouts.app')

@section('title', 'Expenses')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Expenses</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">Add Expense</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                <tr>
                    <td>{{ $expense->expense_date->format('d M Y') }}</td>
                    <td>{{ $expense->title }}</td>
                    <td>{{ $expense->category?->name ?? '—' }}</td>
                    <td>{{ number_format((float) $expense->amount, 2) }}</td>
                    <td>{{ $expense->payment_method ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.expenses.destroy', $expense->id) }}" class="d-inline" onsubmit="return confirm('Delete this expense?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No expenses recorded.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $expenses->links() }}
    </div>
</div>
@endsection
