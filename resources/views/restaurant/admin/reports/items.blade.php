@extends('restaurant.admin.layouts.app')

@section('title', 'Item-wise Report')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Item-wise Report</h4></div>
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
                    <th>Item</th>
                    <th>Quantity Sold</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format((float) $item->total_quantity, 0) }}</td>
                    <td>{{ number_format((float) $item->total_revenue, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted">No item sales in this period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
