<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'registration_id',
    'sort_order',
    'full_name',
    'phone',
    'tshirt_size',
])]
class RegistrationMember extends Model
{
    use HasFactory;

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
