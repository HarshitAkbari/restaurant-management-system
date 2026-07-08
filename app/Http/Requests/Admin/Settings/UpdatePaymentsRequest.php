<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Settings;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'payment_methods' => ['nullable', 'array'],
            'payment_methods.*' => ['string', Rule::enum(PaymentMethod::class)],
        ];
    }
}
