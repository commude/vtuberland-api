<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\MediaTrait;
use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Spot extends Model implements HasMedia
{
    use HasUUID, ScopeTrait, MediaTrait;

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
        'beacon_id', 'name', 'content',
    ];

    /**
     * Get characters of the spot.
     */
    public function characters()
    {
        return $this->hasMany(SpotCharacter::class);
    }
}
