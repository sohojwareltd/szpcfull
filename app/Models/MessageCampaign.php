<?php

namespace App\Models;

use App\Enums\CampaignAudience;
use App\Enums\CampaignStatus;
use App\Enums\ContestType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'body',
    'contest_filter',
    'audience',
    'status',
    'recipients_count',
    'sent_count',
    'failed_count',
    'sent_at',
    'created_by',
])]
class MessageCampaign extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'audience' => CampaignAudience::class,
            'status' => CampaignStatus::class,
            'contest_filter' => ContestType::class,
            'sent_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(MessageLog::class);
    }
}
