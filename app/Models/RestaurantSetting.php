<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantSetting extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'legal_name',
        'phone',
        'email',
        'address',
        'gstin',
        'currency',
        'timezone',
        'cgst_percent',
        'sgst_percent',
        'service_charge_percent',
        'payment_methods',
        'printers',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'cgst_percent' => 'decimal:2',
        'sgst_percent' => 'decimal:2',
        'service_charge_percent' => 'decimal:2',
        'payment_methods' => 'array',
        'printers' => 'array',
    ];
}
