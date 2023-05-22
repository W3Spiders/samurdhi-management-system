<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    /**
     * 
     */
    public function adult_members(): HasMany {
        $marginalDate = Carbon::now()->subYears(40);

        return $this->hasMany(Member::class)->where('birthday', '<=', $marginalDate);
    }

    /**
     * Get the gn division that owns the family unit
     */
    public function gn_division(): BelongsTo {

        return $this->belongsTo(GnDivision::class);
        
    }
}