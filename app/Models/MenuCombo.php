<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MenuCombo extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'description',
        'price',
        'is_active',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'menu_combo_item')
            ->withPivot('quantity');
    }
}
