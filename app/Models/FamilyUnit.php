<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'gn_division_id',
        // 'family_unit_no',
        'primary_member_id',
        'address_line_1',
        'address_line_2',
        'city',
        'postal_code'
    ];

    
    /**
     * Get the members for the family unit.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}