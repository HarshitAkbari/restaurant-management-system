@extends('restaurant.admin.layouts.app')

@section('title', 'Recipes')

@section('content')
<div class="row page-titles">
    <div class="col"><h4 class="mb-0">Recipes</h4></div>
    <div class="col-auto">
        <a href="{{ route('admin.inventory.recipes.create') }}" class="btn btn-primary">Add Recipe</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Menu Item</th>
                    <th>Recipe Name</th>
                    <th>Ingredients</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recipes as $recipe)
                <tr>
                    <td>{{ $recipe->menuItem?->name ?? '—' }}</td>
                    <td>{{ $recipe->name ?? '—' }}</td>
                    <td>{{ $recipe->items->count() }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.inventory.recipes.edit', $recipe->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.inventory.recipes.destroy', $recipe->id) }}" class="d-inline" onsubmit="return confirm('Delete this recipe?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">No recipes yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $recipes->links() }}
    </div>
</div>
@endsection
