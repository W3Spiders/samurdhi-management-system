<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the linked gn_division for the user
     * Not every user has gn_division linked.
     * It's linked only for the GN and SN users.
     */
    public function gn_division(): HasOne
    {

        $foreign_key = (Auth::user()->user_type == 'gn') ? 'gn_user_id' : 'sn_user_id';

        return $this->hasOne(GnDivision::class, $foreign_key);
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
}
