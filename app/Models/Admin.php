<?php

namespace App\Models;

use App\Models\Traits\ScopeTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable, ScopeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
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
     * Set the admin's password in hashed
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
}
