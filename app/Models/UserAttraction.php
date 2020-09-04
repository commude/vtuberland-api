<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttraction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'attraction_id',
    ];

    /**
     * Get the user who owned the attraction.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    /**
     * Get the atraction owned by user.
     */
    public function attraction()
    {
        return $this->hasOne(User::class, 'attraction_id');
    }
}
