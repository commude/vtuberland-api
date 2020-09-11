<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'spot_character_id', 'original_transaction_id', 'transaction_id',
        'purchase_token', 'receipt', 'currency', 'status',
        'purchased_at', 'expired_at'
    ];

    /**
     * Get transactions of the device.
     */
    public function spotCharacter()
    {
        return $this->hasMany(SpotCharacter::class, 'spot_character_id');
    }
}
