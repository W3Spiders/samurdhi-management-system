<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GnDivision extends Model
{
    use HasFactory;

    protected $appends = ['family_units_count'];

    protected $fillable = [
        'ward_no',
        'gn_division_id',
        'gn_division_name',
        'gn_user_id',
        'sn_user_id'
    ];

    /**
     * Get the gn user that owns the gn division
     */
    public function gn_user(): BelongsTo
    {

        return $this->belongsTo(User::class, 'gn_user_id');
    }

    /**
     * Get the sn user that owns the gn division
     */
    public function sn_user(): BelongsTo
    {

        return $this->belongsTo(User::class, 'sn_user_id');
    }

    // Get family units related to the gn division
    public function family_units(): HasMany
    {
        return $this->hasMany(FamilyUnit::class);
    }


    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class, 'ward_no');
    }

    public function samurdhi_payment_requests(): HasMany {
        return $this->hasMany(SamurdhiPaymentRequest::class);
    }

    public function getFamilyUnitsCountAttribute()
    {
        return count($this->hasMany(FamilyUnit::class)->get());
    }

    
}