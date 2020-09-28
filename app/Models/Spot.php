<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasUUID, ScopeTrait;

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
        'beacon_id', 'name', 'content', 'image_path',
    ];

    /**
     * Get characters of the spot.
     */
    public function characters()
    {
        return $this->hasMany(SpotCharacter::class);
    }
}
