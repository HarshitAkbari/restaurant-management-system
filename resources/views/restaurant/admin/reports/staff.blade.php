@extends('restaurant.admin.layouts.app')

@section('title', 'Staff Report')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Staff Report</h4></div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">From</label>
                <input type="date" name="from" class="form-control" value="{{ $from }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">To</label>
                <input type="date" name="to" class="form-control" value="{{ $to }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Staff</th>
                    <th>Orders</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                <tr>
                    <td>{{ $row->staff_name }}</td>
                    <td>{{ $row->order_count }}</td>
                    <td>{{ number_format((float) $row->total_sales, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted">No staff sales in this period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
