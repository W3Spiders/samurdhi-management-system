<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'full_name',
         'gender_string',
         'has_income_string'
    ];


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
    public function family_unit(): BelongsTo
    {

        return $this->belongsTo(FamilyUnit::class);
    }

    public function getFullNameAttribute()
    {
        return ucwords("$this->first_name {$this->last_name}");
    }

    public function getGenderStringAttribute() {
        if ($this->gender === 'm') {
            return 'Male';
        } else if ($this->gender === 'f') {
            return 'Female';
        } else {
            return 'Other';
        }
    }

    public function getHasIncomeStringAttribute() {
        if ($this->has_income == '0') {
            return 'No';
        } else {
            return 'Yes';
        }
    }
}