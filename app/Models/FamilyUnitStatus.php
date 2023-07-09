<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyUnitStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_code',
        'status_title'
    ];
}