<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'loyalty_points',
        'notes',
        'is_active',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'loyalty_points' => 'integer',
        'is_active' => 'boolean',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
