<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FamilyUnit extends Model
{
    use HasFactory;

    protected $appends = [
        'full_address_html'
    ];

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

    /**
     * Get the linked primary member
     */
    public function primary_member(): BelongsTo {
        return $this->belongsTo(Member::class, 'primary_member_id');
    }

    public function getFullAddressHtmlAttribute() {

        $address_html = $this->address_line_1 . '<br />';

        if ($this->address_line_2) {
            $address_html .= $this->address_line_2 . '<br />';
        }

        $address_html .= $this->city . ' ';

        $address_html .= $this->postal_code;

        return $address_html;
    }

    public function getHasMetSamurdhiEligibleCriteriaAttribute() {

        $total_income = 0;

        $members_with_income = $this->members->filter(function ($member) {
            if ($member->monthly_income > 0) {
                return true;
            }

            return false;
        });

        foreach($members_with_income as $member) {
            $total_income += $member->monthly_income;
        }

        // $total_income < 20000 * members_with_income_count;
        if ($total_income < 20000 * count($members_with_income)) {
            return true;
        }

        return false;
    }
}