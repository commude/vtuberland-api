<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasUUID;

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
        return $this->hasManyThrough(Transaction::class, Device::class, 'user_id', 'id', 'id', 'transaction_id');
    }
}
