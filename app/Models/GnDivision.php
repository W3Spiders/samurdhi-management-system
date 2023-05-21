<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}