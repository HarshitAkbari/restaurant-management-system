@extends('restaurant.pos.layouts.app')

@section('title', 'Table View')

@push('styles')
<style>
.pos-table-view { margin: -1rem; min-height: calc(100vh - 52px); background: #f1f5f9; }
.pos-table-view__header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: .75rem 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: .75rem; }
.pos-table-view__title { font-size: 1.1rem; font-weight: 700; margin: 0; }
.pos-table-view__actions { display: flex; gap: .5rem; flex-wrap: wrap; }
.pos-table-legend { display: flex; flex-wrap: wrap; gap: 1rem; padding: .75rem 1rem; background: #fff; border-bottom: 1px solid #e2e8f0; font-size: .8rem; }
.pos-table-legend__item { display: flex; align-items: center; gap: .4rem; }
.pos-table-legend__swatch { width: 18px; height: 18px; border-radius: 3px; border: 2px dashed #cbd5e1; }
.pos-table-legend__swatch--free { background: #fff; }
.pos-table-legend__swatch--occupied { background: #fef08a; border-style: solid; border-color: #eab308; }
.pos-table-legend__swatch--billed { background: #bbf7d0; border-style: solid; border-color: #22c55e; }
.pos-table-legend__swatch--reserved { background: #bfdbfe; border-style: solid; border-color: #3b82f6; }
.pos-table-view__body { padding: 1rem; }
.pos-area-section { margin-bottom: 1.5rem; }
.pos-area-section__title { font-size: .95rem; font-weight: 700; color: #475569; margin-bottom: .75rem; text-transform: uppercase; letter-spacing: .03em; }
.pos-table-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: .75rem; }
.pos-table-card { display: block; text-decoration: none; color: inherit; background: #fff; border: 2px dashed #cbd5e1; border-radius: .5rem; min-height: 100px; padding: .75rem .5rem; text-align: center; transition: transform .1s, box-shadow .15s; cursor: pointer; }
.pos-table-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.1); color: inherit; }
.pos-table-card--occupied { background: #fef9c3; border: 2px solid #eab308; }
.pos-table-card--billed { background: #dcfce7; border: 2px solid #22c55e; }
.pos-table-card--reserved { background: #dbeafe; border: 2px solid #3b82f6; }
.pos-table-card__time { font-size: .7rem; color: #64748b; margin-bottom: .25rem; }
.pos-table-card__name { font-size: 1.5rem; font-weight: 700; line-height: 1.2; }
.pos-table-card__amount { font-size: .8rem; font-weight: 600; color: #0f172a; margin-top: .35rem; }
.pos-table-card__seats { font-size: .7rem; color: #94a3b8; margin-top: .25rem; }
</style>
@endpush

@section('content')
<div class="pos-table-view">
    <div class="pos-table-view__header">
        <h4 class="pos-table-view__title">Table View</h4>
        <div class="pos-table-view__actions">
            <form method="POST" action="{{ route('pos.quick-order', 'takeaway') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">Pick Up</button>
            </form>
            <form method="POST" action="{{ route('pos.quick-order', 'delivery') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">Delivery</button>
            </form>
            <a href="{{ route('pos.orders.index') }}" class="btn btn-outline-secondary btn-sm">All Orders</a>
        </div>
    </div>

    <div class="pos-table-legend">
        <div class="pos-table-legend__item"><span class="pos-table-legend__swatch pos-table-legend__swatch--free"></span> Blank Table</div>
        <div class="pos-table-legend__item"><span class="pos-table-legend__swatch pos-table-legend__swatch--occupied"></span> Running Table</div>
        <div class="pos-table-legend__item"><span class="pos-table-legend__swatch pos-table-legend__swatch--billed"></span> Billed Table</div>
        <div class="pos-table-legend__item"><span class="pos-table-legend__swatch pos-table-legend__swatch--reserved"></span> Reserved</div>
    </div>

    <div class="pos-table-view__body">
        @forelse($areas as $area)
            @if($area->tables->isNotEmpty())
            <div class="pos-area-section">
                <div class="pos-area-section__title">{{ $area->name }}</div>
                <div class="pos-table-grid">
                    @foreach($area->tables as $table)
                    @php
                        $activeOrder = $ordersByTable[$table->id] ?? null;
                        $statusClass = match($table->status->value) {
                            'occupied' => 'pos-table-card--occupied',
                            'billed' => 'pos-table-card--billed',
                            'reserved' => 'pos-table-card--reserved',
                            default => '',
                        };
                        $elapsed = $activeOrder ? $activeOrder->created_at->diffInMinutes(now()) . ' Min' : null;
                    @endphp
                    <a href="{{ route('pos.tables.open', $table->id) }}" class="pos-table-card {{ $statusClass }}">
                        @if($activeOrder)
                        <div class="pos-table-card__time">{{ $elapsed }}</div>
                        @endif
                        <div class="pos-table-card__name">{{ $table->name }}</div>
                        @if($activeOrder && $activeOrder->total_amount > 0)
                        <div class="pos-table-card__amount">₹{{ number_format((float) $activeOrder->total_amount, 2) }}</div>
                        @endif
                        <div class="pos-table-card__seats">{{ $table->capacity }} seats</div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        @empty
            <div class="text-center text-muted py-5">
                <p>No tables configured.</p>
                <a href="{{ route('admin.tables.index') }}" class="btn btn-primary btn-sm">Add tables in Admin</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
