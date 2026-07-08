@php
    use App\Enums\FoodType;

    $type = $foodType ?? FoodType::Veg;
    if (is_string($type)) {
        $type = FoodType::tryFrom($type) ?? FoodType::Veg;
    }
    $size = (int) ($size ?? 16);
@endphp
<span class="pos-food-type-icon" title="{{ $type->label() }}" aria-label="{{ $type->label() }}">
    @if($type === FoodType::Veg)
    <svg viewBox="0 0 20 20" width="{{ $size }}" height="{{ $size }}" class="pos-food-type-icon__svg" aria-hidden="true">
        <rect x="1" y="1" width="18" height="18" fill="#fff" stroke="#22c55e" stroke-width="2"/>
        <circle cx="10" cy="10" r="4.5" fill="#22c55e"/>
    </svg>
    @elseif($type === FoodType::Egg)
    <svg viewBox="0 0 20 20" width="{{ $size }}" height="{{ $size }}" class="pos-food-type-icon__svg" aria-hidden="true">
        <rect x="1" y="1" width="18" height="18" fill="#fff" stroke="#d97706" stroke-width="2"/>
        <ellipse cx="10" cy="11" rx="3.5" ry="4.5" fill="#92400e"/>
    </svg>
    @else
    <svg viewBox="0 0 20 20" width="{{ $size }}" height="{{ $size }}" class="pos-food-type-icon__svg" aria-hidden="true">
        <rect x="1" y="1" width="18" height="18" fill="#fff" stroke="#dc2626" stroke-width="2"/>
        <polygon points="10,5 15,15 5,15" fill="#dc2626"/>
    </svg>
    @endif
</span>
