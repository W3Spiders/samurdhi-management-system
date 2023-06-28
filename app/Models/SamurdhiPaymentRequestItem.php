<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SamurdhiPaymentRequestItem extends Model
{
    use HasFactory;

    public function payment_request(): HasOne {
        return $this->hasOne(SamurdhiPaymentRequest::class);
    }

    public function family_unit(): BelongsTo {
        return $this->belongsTo(FamilyUnit::class);
    }
}