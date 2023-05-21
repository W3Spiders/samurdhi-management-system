<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_unit_id',
        'first_name',
        'last_name',
        'birthday',
        'email',
        'phone'
    ];

    /**
     * Get the family unit that owns the member
     */
    public function family_unit(): BelongsTo {

        return $this->belongsTo(FamilyUnit::class);
        
    }
}