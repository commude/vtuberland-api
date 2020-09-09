<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSpotCharacter extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'spot_id', 'character_id',
    ];

    /**
     * Get user.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get character.
     */
    public function character()
    {
        return $this->hasOne(Character::class);
    }

    /**
     * Get spot.
     */
    public function spot()
    {
        return $this->hasOne(Spot::class);
    }
}
