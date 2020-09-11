<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use MediaTrait;

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
}
