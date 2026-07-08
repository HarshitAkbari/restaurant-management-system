<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrintersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'printer_names' => ['nullable', 'array'],
            'printer_names.*' => ['nullable', 'string', 'max:255'],
            'printer_ips' => ['nullable', 'array'],
            'printer_ips.*' => ['nullable', 'string', 'max:255'],
        ];
    }
}
