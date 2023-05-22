<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GnDivision extends Model
{
    use HasFactory;

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
    public function gn_user(): BelongsTo {

        return $this->belongsTo(User::class, 'gn_user_id');
        
    }
}