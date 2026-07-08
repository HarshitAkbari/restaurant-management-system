<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FoodType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MenuItem extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'menu_category_id',
        'name',
        'sku',
        'description',
        'price',
        'food_type',
        'is_available',
        'is_active',
        'kitchen_station',
        'prep_time_minutes',
        'image_path',
        'sort_order',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'price' => 'decimal:2',
        'food_type' => FoodType::class,
        'is_available' => 'boolean',
        'is_active' => 'boolean',
        'prep_time_minutes' => 'integer',
        'sort_order' => 'integer',
    ];

    /** @var list<string> */
    protected $appends = [
        'is_veg',
    ];

    protected function isVeg(): Attribute
    {
        return Attribute::get(fn (): bool => $this->food_type === FoodType::Veg);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(MenuVariant::class);
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(MenuAddon::class, 'menu_item_addon');
    }

    public function recipe(): HasOne
    {
        return $this->hasOne(Recipe::class);
    }
}
