<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ScopeTrait;

class SpotCharacter extends Model
{
    use ScopeTrait;
    
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
        return $this->belongsTo(Character::class, 'character_id');
    }

    /**
     * Get spot.
     */
    public function spot()
    {
        return $this->hasOne(Spot::class, 'id', 'spot_id');
    }

    /**
     * Get transaction of spotCharacter.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id');
    }

}
