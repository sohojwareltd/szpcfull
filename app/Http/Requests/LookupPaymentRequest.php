<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LookupPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference_code' => ['required', 'string', 'max:16'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('reference_code')) {
            $this->merge([
                'reference_code' => strtoupper(trim((string) $this->input('reference_code'))),
            ]);
        }
    }
}
