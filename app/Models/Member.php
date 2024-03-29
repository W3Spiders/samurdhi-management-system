<?php

namespace App\Models;

use Carbon\Carbon;
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
         'gender_string', 'status_string', 'status_code', 'is_elder', 'age'
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

    public function occupation_type(): BelongsTo {
        return $this->belongsTo(OccupationType::class);
    }

    public function getFullNameAttribute()
    {

        $full_name = $this->first_name;

        if ($this->middle_name) {
            $full_name .= ' ' . $this->middle_name;
        }

        if ($this->last_name) {
            $full_name .= ' ' . $this->last_name;
        }

        return ucwords($full_name);
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

    public function bank_account(): BelongsTo {
        return $this->belongsTo(BankAccount::class);
    }

    public function status(): BelongsTo {
        return $this->belongsTo(MemberStatus::class);
    }

    public function getAgeAttribute() {
        $date = Carbon::create($this->birthday);
        $age = $date->diffInYears(Carbon::now());

        return $age;
    }

    public function getIsElderAttribute() {
        $date = Carbon::create($this->birthday);
        $age = $date->diffInYears(Carbon::now());

        return $age >= 60;
    }

    public function getStatusStringAttribute()
    {
        return $this->belongsTo(MemberStatus::class, 'status_id')->first()->status_title;
    }

    public function getStatusCodeAttribute()
    {
        return $this->belongsTo(MemberStatus::class, 'status_id')->first()->status_code;
    }
}