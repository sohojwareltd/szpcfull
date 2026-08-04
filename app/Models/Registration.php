<?php

namespace App\Models;

use App\Enums\ContestType;
use Illuminate\Database\Eloquent\Builder;
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
    'payment_transaction_id',
    'payment_submitted_at',
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
            'payment_submitted_at' => 'datetime',
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

    public function contestFeeAmount(): int
    {
        return (int) (config('services.contest_payment.fees.'.$this->contest_type->value) ?? 0);
    }

    public function supportsBkashSelfPay(): bool
    {
        return $this->contest_type === ContestType::Ithq;
    }

    /**
     * @param  Builder<Registration>  $query
     * @return Builder<Registration>
     */
    public function scopePendingPaymentVerification(Builder $query): Builder
    {
        return $query
            ->whereNotNull('payment_transaction_id')
            ->where('is_paid', false);
    }

    /**
     * @return list<array{key: string, label: string, done: bool, current: bool, hint: ?string}>
     */
    public function progressTimeline(): array
    {
        $registered = true;
        $paymentSubmitted = filled($this->payment_transaction_id);
        $paid = $this->is_paid;
        $confirmed = $this->is_confirmed;

        $steps = [
            [
                'key' => 'registered',
                'label' => 'Registration received',
                'done' => $registered,
                'current' => ! $paymentSubmitted && ! $paid && ! $confirmed,
                'hint' => null,
            ],
        ];

        if ($this->supportsBkashSelfPay()) {
            $steps[] = [
                'key' => 'payment_submitted',
                'label' => 'Payment submitted',
                'done' => $paymentSubmitted || $paid,
                'current' => $registered && ! $paid && ! $paymentSubmitted,
                'hint' => $paymentSubmitted && ! $paid ? 'Transaction ID on file — verification pending' : null,
            ];
        } else {
            $steps[] = [
                'key' => 'contacted',
                'label' => 'Committee contact',
                'done' => $this->is_contacted || $paid,
                'current' => $registered && ! $this->is_contacted && ! $paid,
                'hint' => null,
            ];
        }

        $steps[] = [
            'key' => 'paid',
            'label' => 'Fee verified',
            'done' => $paid,
            'current' => ($paymentSubmitted || $this->is_contacted || ! $this->supportsBkashSelfPay()) && ! $paid && ! $confirmed,
            'hint' => $paid ? ($this->paid_at?->format('M j, Y g:i A') ?? null) : null,
        ];

        $steps[] = [
            'key' => 'confirmed',
            'label' => 'Spot confirmed',
            'done' => $confirmed,
            'current' => $paid && ! $confirmed,
            'hint' => $confirmed ? ($this->confirmed_at?->format('M j, Y g:i A') ?? null) : null,
        ];

        return $steps;
    }
}
