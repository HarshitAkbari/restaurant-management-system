<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\KotStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kot extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'order_id',
        'kot_number',
        'station',
        'status',
        'created_by',
        'ready_at',
        'served_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'status' => KotStatus::class,
        'ready_at' => 'datetime',
        'served_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(KotItem::class);
    }
}
