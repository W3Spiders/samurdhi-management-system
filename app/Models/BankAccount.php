<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{

    protected $fillable = [
        'account_number',
        'holder_name',
        'branch',
        'name'
    ];

    use HasFactory;

}