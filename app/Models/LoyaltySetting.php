<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltySetting extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'is_enabled',
        'points_per_rupee',
        'rupee_per_point',
        'min_redeem_points',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'is_enabled' => 'boolean',
        'points_per_rupee' => 'decimal:4',
        'rupee_per_point' => 'decimal:4',
        'min_redeem_points' => 'integer',
    ];
}
