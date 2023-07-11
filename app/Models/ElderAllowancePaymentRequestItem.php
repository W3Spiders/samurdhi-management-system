<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ElderAllowancePaymentRequestItem extends Model
{
    use HasFactory;

    public function payment_request(): HasOne {
        return $this->hasOne(ElderAllowancePaymentRequest::class);
    }

    public function member(): BelongsTo {
        return $this->belongsTo(Member::class);
    }
}