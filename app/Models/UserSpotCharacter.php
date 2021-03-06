<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ScopeTrait;

class UserSpotCharacter extends Model
{
    use ScopeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'spot_id', 'character_id', 'expired_at'
    ];

    /**
     * Get user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get character.
     */
    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id', 'id');
    }

    /**
     * Get spot.
     */
    public function spot()
    {
        return $this->hasOne(Spot::class, 'id', 'spot_id');
    }
}
