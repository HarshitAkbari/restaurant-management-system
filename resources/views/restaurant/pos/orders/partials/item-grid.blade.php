@php use App\Enums\FoodType; @endphp
<section class="pos-item-panel">
    <div class="pos-item-panel__toolbar">
        <input type="search" id="pos-item-search" class="form-control" placeholder="Search item or short code..." autocomplete="off">
    </div>
    <div class="pos-item-grid" id="pos-item-grid">
        @foreach($menuCategories as $category)
            @foreach($category->items as $item)
            @php
                $cardClass = match ($item->food_type) {
                    FoodType::Veg => 'pos-item-card--veg',
                    FoodType::Egg => 'pos-item-card--egg',
                    default => 'pos-item-card--nonveg',
                };
            @endphp
            <button
                type="button"
                class="pos-item-card {{ $cardClass }}"
                data-category-id="{{ $category->id }}"
                data-item-id="{{ $item->id }}"
                data-name="{{ $item->name }}"
                data-sku="{{ $item->sku ?? '' }}"
                data-price="{{ $item->price }}"
                data-search="{{ strtolower($item->name . ' ' . ($item->sku ?? '')) }}"
                @if(!$order->status->isActive()) disabled @endif
            >
                <span class="pos-item-card__food-type">
                    @include('restaurant.pos.orders.partials.food-type-icon', ['foodType' => $item->food_type, 'size' => 12])
                </span>
                <span class="pos-item-card__name">{{ $item->name }}</span>
                <span class="pos-item-card__price">₹{{ number_format((float) $item->price, 0) }}</span>
            </button>
            @endforeach
        @endforeach
        <div class="pos-item-grid__empty d-none" id="pos-item-empty">
            <p class="text-muted mb-0">No items match your search.</p>
        </div>
    </div>
</section>
