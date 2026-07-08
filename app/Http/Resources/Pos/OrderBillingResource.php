<?php

declare(strict_types=1);

namespace App\Http\Resources\Pos;

use App\Enums\FoodType;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Order */
class OrderBillingResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        $paid = (float) $this->payments->sum('amount');

        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'is_active' => $this->status->isActive(),
            'subtotal' => (float) $this->subtotal,
            'tax_amount' => (float) $this->tax_amount,
            'service_charge' => (float) $this->service_charge,
            'total_amount' => (float) $this->total_amount,
            'paid_amount' => $paid,
            'balance_due' => max((float) $this->total_amount - $paid, 0),
            'items' => $this->items->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'line_total' => (float) $item->line_total,
                'kot_sent' => (bool) $item->kot_sent,
                'food_type' => ($item->menuItem?->food_type ?? FoodType::Veg)->value,
                'is_veg' => ($item->menuItem?->food_type ?? FoodType::Veg) === FoodType::Veg,
                'notes' => $item->notes,
                'addons' => $item->addons ?? [],
            ])->values()->all(),
        ];
    }
}
