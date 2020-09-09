<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasUUID, MediaTrait;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'beacon_id', 'name', 'content', 'video_url', 'location', 'image_url'
    ];

    /**
     * Get characters of the spot.
     */
    public function characters()
    {
        return $this->hasMany(SpotCharacter::class);
    }
}
