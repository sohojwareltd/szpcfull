<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'favicon',
        'theme_color',
        'twitter_site',
        'robots_index',
        'google_site_verification',
        'contact_email',
        'contact_phone',
        'contact_address',
        'register_meta_title',
        'register_meta_description',
        'success_meta_title',
        'success_meta_description',
        'analytics_measurement_id',
        'registration_submitted_sms_enabled',
        'registration_submitted_sms_template',
    ];

    protected function casts(): array
    {
        return [
            'robots_index' => 'boolean',
            'registration_submitted_sms_enabled' => 'boolean',
        ];
    }

    public static function current(): self
    {
        // Legacy cache stored a serialized model and can break after deploys.
        Cache::forget('site_settings');

        $id = Cache::get('site_settings_id');

        if ($id !== null) {
            $settings = self::query()->find($id);
            if ($settings instanceof self) {
                return $settings;
            }

            Cache::forget('site_settings_id');
        }

        $settings = self::query()->first();

        if (! $settings) {
            $settings = self::query()->create(self::defaultAttributes());
        }

        Cache::forever('site_settings_id', $settings->id);

        return $settings;
    }

    public static function clearCache(): void
    {
        Cache::forget('site_settings');
        Cache::forget('site_settings_id');
    }

    /**
     * @return array<string, mixed>
     */
    public static function defaultAttributes(): array
    {
        return [
            'site_name' => "SZPC '26",
            'meta_title' => "SZPC '26 — South Zone Programming Contest | University of Global Village",
            'meta_description' => "SZPC '26 — 3rd UGV South Zone Programming Contest & ICT Talent Hunt, 10 October 2026 at University of Global Village, Barishal.",
            'meta_keywords' => 'SZPC, programming contest, UGV, Barishal, JPC, ITHQ, competitive programming',
            'og_title' => "SZPC '26 — South Zone Programming Contest",
            'og_description' => 'Code. Solve. Quiz. Compete. 10 October 2026 at University of Global Village, Barishal.',
            'theme_color' => '#1a1d24',
            'robots_index' => true,
            'contact_email' => 'szpc@ugv.edu.bd',
            'contact_phone' => '+880 1700-000000',
            'contact_address' => "CSE Dept., UGV Campus,\nBarishal 8200, Bangladesh",
            'register_meta_title' => "Register — SZPC '26 | UGV Contest Registration 2026",
            'register_meta_description' => 'Register for SZPC-2026, JPC-2026 or ITHQ-2026 — UGV Contest Registration 2026.',
            'success_meta_title' => "Registration received — SZPC '26",
            'success_meta_description' => 'Your contest registration was submitted successfully.',
            'registration_submitted_sms_enabled' => true,
            'registration_submitted_sms_template' => "SZPC '26: Hello {{member_name}}, your registration is received. Ref: {{reference_code}} ({{contest_type}}). Track payment: {{payment_url}} — UGV Programming Club",
        ];
    }

    /**
     * @return array{title: string, description: string, keywords: ?string, robots: string}
     */
    public function metaFor(string $page = 'home'): array
    {
        return match ($page) {
            'register' => [
                'title' => $this->register_meta_title ?: $this->meta_title ?: $this->site_name,
                'description' => $this->register_meta_description ?: $this->meta_description ?: '',
                'keywords' => $this->meta_keywords,
                'robots' => $this->robots_index ? 'index, follow' : 'noindex, nofollow',
            ],
            'success' => [
                'title' => $this->success_meta_title ?: $this->meta_title ?: $this->site_name,
                'description' => $this->success_meta_description ?: $this->meta_description ?: '',
                'keywords' => $this->meta_keywords,
                'robots' => 'noindex, follow',
            ],
            'payment' => [
                'title' => "Payment & status — {$this->site_name}",
                'description' => 'Look up your registration reference code to view payment progress and submit bKash transaction details.',
                'keywords' => $this->meta_keywords,
                'robots' => 'noindex, follow',
            ],
            default => [
                'title' => $this->meta_title ?: $this->site_name,
                'description' => $this->meta_description ?: '',
                'keywords' => $this->meta_keywords,
                'robots' => $this->robots_index ? 'index, follow' : 'noindex, nofollow',
            ],
        };
    }

    public function faviconUrl(): string
    {
        if ($this->favicon && Storage::disk('public')->exists($this->favicon)) {
            return Storage::disk('public')->url($this->favicon);
        }

        return 'data:image/svg+xml,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><rect width="32" height="32" fill="#050505"/><text x="6" y="24" font-family="monospace" font-size="20" fill="#00FF41">&gt;_</text></svg>');
    }

    public function ogImageUrl(): ?string
    {
        if ($this->og_image && Storage::disk('public')->exists($this->og_image)) {
            return Storage::disk('public')->url($this->og_image);
        }

        return null;
    }

    public function canonicalUrl(): string
    {
        return url()->current();
    }

    public function registrationSubmittedSmsTemplateOrDefault(): string
    {
        if (filled(trim((string) $this->registration_submitted_sms_template))) {
            return trim((string) $this->registration_submitted_sms_template);
        }

        return self::defaultAttributes()['registration_submitted_sms_template'];
    }
}
