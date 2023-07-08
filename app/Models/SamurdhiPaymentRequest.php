<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SamurdhiPaymentRequest extends Model
{
    use HasFactory;

    protected $appends = ['status_string', 'status_code'];

    public function items(): HasMany
    {
        return $this->hasMany(SamurdhiPaymentRequestItem::class);
    }

    public function gn_division(): BelongsTo
    {
        return $this->belongsTo(GnDivision::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PaymentRequestStatus::class, 'status_id');
    }

    public function getStatusStringAttribute()
    {
        return $this->belongsTo(PaymentRequestStatus::class, 'status_id')->first()->status_title;
    }

    public function getStatusCodeAttribute()
    {
        return $this->belongsTo(PaymentRequestStatus::class, 'status_id')->first()->status_code;
    }
}
