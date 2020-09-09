<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpotCharacter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spot_id', 'character_id', 'video_url'
    ];

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
