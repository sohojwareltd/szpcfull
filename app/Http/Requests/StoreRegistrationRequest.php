<?php

namespace App\Http\Requests;

use App\Enums\ContestType;
use App\Rules\Turnstile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contest = $this->input('contest_type');

        $rules = [
            'contest_type' => ['required', Rule::enum(ContestType::class)],
            'company_website' => ['nullable', 'string', 'max:255'],
            'cf-turnstile-response' => ['required', 'string', new Turnstile],
        ];

        if ($contest === ContestType::Szpc->value) {
            $rules += [
                'team_name' => ['required', 'string', 'max:255'],
                'university' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'email', 'max:255'],
                'member1_full_name' => ['required', 'string', 'max:255'],
                'member1_phone' => ['required', 'string', 'max:32'],
                'member1_tshirt' => ['required', Rule::in(['XS', 'S', 'M', 'L', 'XL', 'XXL'])],
                'member2_full_name' => ['nullable', 'string', 'max:255'],
                'member2_tshirt' => ['nullable', Rule::in(['XS', 'S', 'M', 'L', 'XL', 'XXL'])],
                'member3_full_name' => ['nullable', 'string', 'max:255'],
                'member3_tshirt' => ['nullable', Rule::in(['XS', 'S', 'M', 'L', 'XL', 'XXL'])],
            ];
        } elseif ($contest === ContestType::Jpc->value) {
            $rules += [
                'category' => ['required', Rule::in(['School', 'College', 'Polytechnic'])],
                'institution_name' => ['required', 'string', 'max:255'],
                'district' => ['required', 'string', 'max:255'],
                'team_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'member1_full_name' => ['required', 'string', 'max:255'],
                'member1_phone' => ['required', 'string', 'max:32'],
                'member1_tshirt' => ['required', Rule::in(['XS', 'S', 'M', 'L', 'XL', 'XXL'])],
                'member2_full_name' => ['nullable', 'string', 'max:255'],
                'member2_tshirt' => ['nullable', Rule::in(['XS', 'S', 'M', 'L', 'XL', 'XXL'])],
                'member3_full_name' => ['nullable', 'string', 'max:255'],
                'member3_tshirt' => ['nullable', Rule::in(['XS', 'S', 'M', 'L', 'XL', 'XXL'])],
            ];
        } elseif ($contest === ContestType::Ithq->value) {
            $rules += [
                'category' => ['required', Rule::in(['School', 'College'])],
                'full_name' => ['required', 'string', 'max:255'],
                'institution_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'phone' => ['required', 'string', 'max:32'],
                'address' => ['required', 'string', 'max:500'],
            ];
        }

        return $rules;
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (filled($this->input('company_website'))) {
                Log::info('Registration honeypot triggered.', [
                    'ip' => $this->ip(),
                    'user_agent' => $this->userAgent(),
                ]);
                $validator->errors()->add('company_website', 'Unable to submit registration. Please try again.');
            }
        });
    }
}
