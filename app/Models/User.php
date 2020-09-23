<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\MediaTrait;
use App\Models\Traits\ScopeTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasUUID, MediaTrait, ScopeTrait;

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
        'name', 'email', 'password', 'is_valid',
        'manufacturer', 'os', 'version', 'language'
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
     * Get spots of the user.
     */
    public function spots()
    {
        return $this->hasManyThrough(Spot::class, UserSpotCharacter::class, 'user_id', 'id', 'id', 'spot_id');
    }

    /**
     * Get chatacters of the user.
     */
    public function spotCharacters()
    {
        return $this->hasMany(UserSpotCharacter::class);
    }

    /**
     * Get purchases of the user.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
