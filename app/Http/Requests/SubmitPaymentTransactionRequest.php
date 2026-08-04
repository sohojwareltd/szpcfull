<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitPaymentTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_transaction_id' => ['required', 'string', 'min:6', 'max:64', 'regex:/^[A-Za-z0-9]+$/'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('payment_transaction_id')) {
            $this->merge([
                'payment_transaction_id' => strtoupper(trim((string) $this->input('payment_transaction_id'))),
            ]);
        }
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'payment_transaction_id.regex' => 'Enter the bKash transaction ID (letters and numbers only).',
        ];
    }
}
