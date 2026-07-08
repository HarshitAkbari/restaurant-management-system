@php use App\Enums\FoodType; @endphp
<div class="mb-3">
    <label class="form-label d-block">Food Type</label>
    <div class="d-flex flex-wrap gap-3">
        @foreach(FoodType::cases() as $type)
        <div class="form-check custom-radio">
            <input type="radio" name="food_type" id="food_type_{{ $type->value }}" value="{{ $type->value }}"
                class="form-check-input @error('food_type') is-invalid @enderror"
                {{ old('food_type', $selected ?? FoodType::Veg->value) === $type->value ? 'checked' : '' }}>
            <label class="form-check-label d-inline-flex align-items-center gap-1" for="food_type_{{ $type->value }}">
                @include('restaurant.pos.orders.partials.food-type-icon', ['foodType' => $type, 'size' => 14])
                {{ $type->label() }}
            </label>
        </div>
        @endforeach
    </div>
    @error('food_type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>
