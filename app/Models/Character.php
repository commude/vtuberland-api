<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\MediaTrait;
use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use MediaTrait, ScopeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'content', 'price', 'image_url'
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
