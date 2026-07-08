@extends('restaurant.admin.layouts.app')

@section('title', 'Edit Recipe')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Edit Recipe</h4></div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.inventory.recipes.update', $recipe->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Menu Item</label>
                <select name="menu_item_id" class="form-select" required>
                    @foreach($menuItems as $item)
                    <option value="{{ $item->id }}" {{ old('menu_item_id', $recipe->menu_item_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Recipe Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $recipe->name) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $recipe->notes) }}</textarea>
            </div>
            <h5 class="mb-3">Ingredients</h5>
            @php $existing = $recipe->items->values(); @endphp
            @for($i = 0; $i < 5; $i++)
            <div class="row mb-2">
                <div class="col-md-7">
                    <select name="items[{{ $i }}][raw_material_id]" class="form-select">
                        <option value="">Raw material</option>
                        @foreach($materials as $material)
                        <option value="{{ $material->id }}" {{ old("items.$i.raw_material_id", $existing[$i]->raw_material_id ?? '') == $material->id ? 'selected' : '' }}>{{ $material->name }} ({{ $material->unit }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="number" step="0.001" name="items[{{ $i }}][quantity]" class="form-control" placeholder="Quantity" value="{{ old("items.$i.quantity", $existing[$i]->quantity ?? '') }}" min="0">
                </div>
            </div>
            @endfor
            <button type="submit" class="btn btn-primary mt-3">Update</button>
            <a href="{{ route('admin.inventory.recipes.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
@endsection
