<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'team_id',
    'registration_member_id',
    'full_name',
    'phone',
    'email',
    'tshirt_size',
    'is_leader',
    'sort_order',
])]
class TeamMember extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_leader' => 'boolean',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function registrationMember(): BelongsTo
    {
        return $this->belongsTo(RegistrationMember::class);
    }

    public function messageLogs(): HasMany
    {
        return $this->hasMany(MessageLog::class);
    }

    public function displayPhone(): ?string
    {
        if (filled($this->phone)) {
            return $this->phone;
        }

        if ($this->is_leader && $this->team?->registration) {
            return $this->team->registration->phone;
        }

        return null;
    }
}
