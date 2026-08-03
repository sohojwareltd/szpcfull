<?php

namespace App\Models;

use App\Enums\ContestType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'registration_id',
    'contest_type',
    'name',
    'leader_id',
])]
class Team extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'contest_type' => ContestType::class,
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class)->orderBy('sort_order');
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'leader_id');
    }

    public function messageLogs(): HasMany
    {
        return $this->hasMany(MessageLog::class);
    }
}
