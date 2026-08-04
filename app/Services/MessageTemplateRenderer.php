<?php

namespace App\Services;

use App\Enums\ContestType;
use App\Models\Registration;
use App\Models\TeamMember;

class MessageTemplateRenderer
{
    /**
     * Placeholders: reference_code, contest_type, team_name, university, institution_name,
     * district, category, email, phone, address, member_name, member_phone, member_tshirt,
     * leader_name, leader_phone, full_name
     */
    public static function placeholderHelp(): string
    {
        return implode(', ', array_map(
            fn (string $key): string => '{{'.$key.'}}',
            self::keys(),
        ));
    }

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return [
            'reference_code',
            'contest_type',
            'team_name',
            'university',
            'institution_name',
            'district',
            'category',
            'email',
            'phone',
            'address',
            'full_name',
            'member_name',
            'member_phone',
            'member_tshirt',
            'leader_name',
            'leader_phone',
            'payment_url',
        ];
    }

    public function render(string $template, Registration $registration, ?TeamMember $member = null): string
    {
        $leader = $registration->team?->leader;
        $memberForContext = $member ?? $leader;

        $replacements = [
            'reference_code' => $registration->reference_code,
            'contest_type' => $registration->contest_type->value,
            'team_name' => $registration->team_name ?? $registration->team?->name ?? '',
            'university' => $registration->university ?? '',
            'institution_name' => $registration->institution_name ?? '',
            'district' => $registration->district ?? '',
            'category' => $registration->category ?? '',
            'email' => $registration->email ?? '',
            'phone' => $registration->phone ?? '',
            'address' => $registration->address ?? '',
            'full_name' => $registration->full_name ?? $memberForContext?->full_name ?? '',
            'member_name' => $memberForContext?->full_name ?? $registration->full_name ?? '',
            'member_phone' => $memberForContext?->displayPhone() ?? $registration->phone ?? '',
            'member_tshirt' => $memberForContext?->tshirt_size ?? '',
            'leader_name' => $leader?->full_name ?? $registration->full_name ?? '',
            'leader_phone' => $leader?->displayPhone() ?? $registration->phone ?? '',
            'payment_url' => route('payment.show', $registration->reference_code),
        ];

        $output = $template;
        foreach ($replacements as $key => $value) {
            $output = str_replace('{{'.$key.'}}', (string) $value, $output);
        }

        return $output;
    }
}
