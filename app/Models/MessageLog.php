<?php

namespace App\Models;

use App\Enums\MessageLogStatus;
use App\Enums\MessageType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'message_campaign_id',
    'registration_id',
    'team_id',
    'team_member_id',
    'message_type',
    'recipient_type',
    'recipient_phone',
    'recipient_name',
    'message_body',
    'template_body',
    'status',
    'error_message',
    'provider_response',
    'sent_by',
    'sent_at',
])]
class MessageLog extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'message_type' => MessageType::class,
            'status' => MessageLogStatus::class,
            'sent_at' => 'datetime',
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(MessageCampaign::class, 'message_campaign_id');
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
