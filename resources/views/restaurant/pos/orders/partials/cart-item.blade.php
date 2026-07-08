@php
    use App\Enums\FoodType;

    $foodType = $item->menuItem?->food_type ?? FoodType::Veg;
    $hasMeta = !empty($item->notes) || !empty($item->addons);
@endphp
<li class="list-group-item border-0 py-1 px-2 pos-cart-item-wrap" data-item-id="{{ $item->id }}">
    <div class="pos-cart-item pos-cart-row {{ $item->kot_sent ? 'pos-cart-item--kot' : '' }}">
        @if($order->status->isActive())
        <button type="button" class="btn btn-danger light btn-xs sharp pos-cart-row__remove" data-action="remove" data-item-id="{{ $item->id }}" title="Remove" aria-label="Remove item">
            <i class="fa fa-times"></i>
        </button>
        @else
        <span class="pos-cart-row__remove pos-cart-row__remove--spacer"></span>
        @endif

        <div class="pos-cart-row__item min-w-0">
            @include('restaurant.pos.orders.partials.food-type-icon', ['foodType' => $foodType])
            <span class="pos-cart-item__name text-truncate">{{ $item->name }}</span>
            @if($item->kot_sent)
            <span class="badge badge-success light badge-xs flex-shrink-0">KOT</span>
            @endif
        </div>

        <div class="pos-cart-row__qty">
            @if($order->status->isActive())
            <div class="input-group input-group-sm pos-qty-group">
                <button type="button" class="btn btn-outline-secondary" data-action="decrease" data-item-id="{{ $item->id }}" data-qty="{{ $item->quantity }}" aria-label="Decrease quantity">−</button>
                <input type="text" class="form-control text-center px-1 fw-bold" value="{{ $item->quantity }}" readonly tabindex="-1" aria-label="Quantity">
                <button type="button" class="btn btn-primary" data-action="increase" data-item-id="{{ $item->id }}" data-qty="{{ $item->quantity }}" aria-label="Increase quantity">+</button>
            </div>
            @else
            <span class="badge badge-primary light">{{ $item->quantity }}</span>
            @endif
        </div>

        <div class="pos-cart-row__price text-end">
            <span class="pos-cart-item__total">₹{{ number_format($item->line_total, 0) }}</span>
            <small class="text-muted d-block lh-1">{{ number_format($item->unit_price, 0) }}</small>
        </div>
    </div>
    @if($hasMeta)
    <div class="pos-cart-row__meta text-muted">
        @if(!empty($item->notes)){{ $item->notes }}@endif
        @if(!empty($item->addons)) + {{ collect($item->addons)->pluck('name')->filter()->implode(', ') }}@endif
    </div>
    @endif
</li>
