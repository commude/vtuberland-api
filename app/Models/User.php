<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\MediaTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasUUID, MediaTrait;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'is_valid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Find the user instance for the given username.
     *
     * @param string  $username
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Set the user's password in hashed
     *
     * @var array
     */
    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value)) {
            $password = Hash::make($value);
        }

        $this->attributes['password'] = $password;
    }

    /**
     * Get devices of the user.
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Get attractions of the user.
     */
    public function attractions()
    {
        return $this->hasMany(UserAttraction::class);
    }

    /**
     * Get transactions of the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
