<?php

declare(strict_types=1);

namespace App\Http\Requests\Pos;

use Illuminate\Foundation\Http\FormRequest;

class AddOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'menu_item_id' => ['nullable', 'integer', 'exists:menu_items,id'],
            'menu_variant_id' => ['nullable', 'integer', 'exists:menu_variants,id'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
