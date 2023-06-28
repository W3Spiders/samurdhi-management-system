<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SamurdhiPaymentRequest extends Model
{
    use HasFactory;

    public function items(): HasMany {
        return $this->hasMany(SamurdhiPaymentRequestItem::class);
    }

    public function gn_division(): BelongsTo{
        return $this->belongsTo(GnDivision::class);
    }

}