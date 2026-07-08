<?php

declare(strict_types=1);

namespace App\Http\Requests\Pos;

use App\Enums\KotStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKotStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::enum(KotStatus::class)],
        ];
    }
}
