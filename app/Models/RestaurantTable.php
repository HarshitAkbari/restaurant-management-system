<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TableStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantTable extends Model
{
    protected $table = 'restaurant_tables';

    /** @var list<string> */
    protected $fillable = [
        'area_id',
        'name',
        'code',
        'capacity',
        'status',
        'pos_x',
        'pos_y',
        'is_active',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'capacity' => 'integer',
        'status' => TableStatus::class,
        'pos_x' => 'integer',
        'pos_y' => 'integer',
        'is_active' => 'boolean',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
