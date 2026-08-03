<?php

namespace App\Models;

use App\Enums\ContestType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'reference_code',
    'contest_type',
    'team_name',
    'university',
    'institution_name',
    'district',
    'category',
    'full_name',
    'email',
    'phone',
    'address',
    'is_contacted',
    'contacted_at',
    'is_paid',
    'paid_at',
    'is_confirmed',
    'confirmed_at',
    'admin_notes',
    'last_sms_at',
])]
class Registration extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'contest_type' => ContestType::class,
            'is_contacted' => 'boolean',
            'contacted_at' => 'datetime',
            'is_paid' => 'boolean',
            'paid_at' => 'datetime',
            'is_confirmed' => 'boolean',
            'confirmed_at' => 'datetime',
            'last_sms_at' => 'datetime',
        ];
    }

    public function members(): HasMany
    {
        return $this->hasMany(RegistrationMember::class)->orderBy('sort_order');
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class);
    }

    public function messageLogs(): HasMany
    {
        return $this->hasMany(MessageLog::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(RegistrationNote::class)->latest();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function displayName(): string
    {
        return $this->team_name
            ?? $this->full_name
            ?? $this->reference_code;
    }

    public function smsRecipientPhone(): string
    {
        return $this->phone;
    }
}
