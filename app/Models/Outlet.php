<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'code',
        'phone',
        'address',
        'is_active',
        'is_primary',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'is_active' => 'boolean',
        'is_primary' => 'boolean',
    ];
}
