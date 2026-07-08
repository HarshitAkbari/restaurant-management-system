@extends('restaurant.pos.layouts.app')

@section('title', 'Kitchen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0">Kitchen Display</h4>
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="station" class="form-control form-control-sm" placeholder="Station filter" value="{{ $station }}">
        <button class="btn btn-sm btn-outline-primary">Filter</button>
    </form>
</div>

<div class="row g-3">
    @forelse($kots as $kot)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>{{ $kot->kot_number }}</strong>
                <span class="badge bg-warning text-dark">{{ $kot->status->label() }}</span>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    Order: {{ $kot->order?->order_number ?? '—' }}
                    @if($kot->station) · {{ $kot->station }} @endif
                </p>
                <ul class="list-unstyled mb-3">
                    @foreach($kot->items as $item)
                    <li><strong>{{ $item->quantity }}×</strong> {{ $item->name }}</li>
                    @endforeach
                </ul>
                <div class="d-flex flex-wrap gap-1">
                    @foreach([\App\Enums\KotStatus::Preparing, \App\Enums\KotStatus::Ready, \App\Enums\KotStatus::Served] as $status)
                    <form method="POST" action="{{ route('pos.kitchen.update-status', $kot->id) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $status->value }}">
                        <button class="btn btn-sm btn-outline-primary">{{ $status->label() }}</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12"><div class="alert alert-secondary">No pending KOTs.</div></div>
    @endforelse
</div>
@endsection
