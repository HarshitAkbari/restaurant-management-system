@extends('restaurant.admin.layouts.app')

@section('title', 'Table Layout')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Table Layout</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.tables.index') }}" class="btn btn-outline-secondary">Back to Tables</a>
    </div>
</div>

@foreach($areas as $area)
<div class="card mb-4">
    <div class="card-header"><h5 class="mb-0">{{ $area->name }}</h5></div>
    <div class="card-body">
        <div class="row g-3">
            @forelse($area->tables as $table)
            @php
                $statusClass = match($table->status->value) {
                    'free' => 'bg-success',
                    'occupied' => 'bg-danger',
                    'billed' => 'bg-warning text-dark',
                    'reserved' => 'bg-info',
                    default => 'bg-secondary',
                };
            @endphp
            <div class="col-md-3 col-sm-4 col-6">
                <div class="border rounded p-3 text-center {{ $statusClass }} bg-opacity-10">
                    <strong>{{ $table->name }}</strong>
                    <div class="small text-muted">Cap: {{ $table->capacity }}</div>
                    <span class="badge {{ $statusClass }}">{{ $table->status->label() }}</span>
                    <div class="small text-muted mt-1">({{ $table->pos_x }}, {{ $table->pos_y }})</div>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted">No tables in this area.</div>
            @endforelse
        </div>
    </div>
</div>
@endforeach
@endsection
