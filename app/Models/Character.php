<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
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
        'name', 'content', 'image_path'
    ];

    /**
     * Get spots.
     */
    public function spots()
    {
        return $this->hasMany(SpotCharacter::class);
    }

    /**
     * Get transactions of the device.
     */
    public function spotCharacter()
    {
        return $this->hasMany(SpotCharacter::class, 'id');
    }
}
