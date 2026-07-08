<aside class="pos-menu-sidebar">
    <div class="pos-menu-sidebar__title">Menu</div>
    <button type="button" class="pos-category-btn active" data-category-id="all">
        All Items
    </button>
    @foreach($menuCategories as $category)
        @if($category->items->isNotEmpty())
        <button type="button" class="pos-category-btn" data-category-id="{{ $category->id }}">
            {{ $category->name }}
        </button>
        @endif
    @endforeach
</aside>
