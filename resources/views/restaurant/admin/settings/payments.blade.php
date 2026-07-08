@extends('restaurant.admin.layouts.app')

@section('title', 'Payment Methods')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Payment Methods</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.payments.update') }}">
            @csrf
            @method('PUT')
            @php
                $enabled = collect(old('payment_methods', $setting->payment_methods ?? []))
                    ->map(fn (mixed $method) => is_array($method) ? ($method['code'] ?? null) : $method)
                    ->filter()
                    ->all();
            @endphp
            <div class="row">
                @foreach(\App\Enums\PaymentMethod::cases() as $method)
                <div class="col-md-4 mb-2">
                    <div class="form-check">
                        <input type="checkbox" name="payment_methods[]" value="{{ $method->value }}" class="form-check-input" id="pm_{{ $method->value }}"
                            @checked(in_array($method->value, $enabled, true))>
                        <label class="form-check-label" for="pm_{{ $method->value }}">{{ $method->label() }}</label>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Payment Methods</button>
        </form>
    </div>
</div>
@endsection
