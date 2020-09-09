<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\MediaTrait;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasUUID, MediaTrait;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
