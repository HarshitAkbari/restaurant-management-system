@extends('restaurant.pos.layouts.app')

@section('title', 'Day Close')

@section('content')
<h4 class="mb-3">Day Close</h4>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Preview</h6></div>
            <div class="card-body">
                <form method="GET" class="mb-3 d-flex gap-2">
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                    <button class="btn btn-outline-primary">Load</button>
                </form>

                @if($preview['already_closed'])
                <div class="alert alert-warning">Day close already recorded for this date.</div>
                @endif

                <p><strong>Business Date:</strong> {{ $preview['business_date'] }}</p>
                <p><strong>Total Sales:</strong> ₹{{ number_format($preview['total_sales'], 2) }}</p>
                <p><strong>Total Orders:</strong> {{ $preview['total_orders'] }}</p>

                @if(!empty($preview['payment_breakdown']))
                <h6 class="mt-3">Payment Breakdown</h6>
                <ul class="list-unstyled">
                    @foreach($preview['payment_breakdown'] as $method => $amount)
                    <li class="d-flex justify-content-between"><span>{{ ucfirst($method) }}</span><span>₹{{ number_format($amount, 2) }}</span></li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Close Day</h6></div>
            <div class="card-body">
                @if($preview['already_closed'])
                <p class="text-muted mb-0">This date is already closed.</p>
                @else
                <form method="POST" action="{{ route('pos.day-close.store') }}">
                    @csrf
                    <input type="hidden" name="business_date" value="{{ $date }}">
                    <div class="mb-3">
                        <label class="form-label">Opening Cash</label>
                        <input type="number" step="0.01" name="opening_cash" class="form-control" value="{{ old('opening_cash', 0) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Closing Cash (counted)</label>
                        <input type="number" step="0.01" name="closing_cash" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>
                    <button class="btn btn-primary" onclick="return confirm('Close business day?')">Close Day</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
