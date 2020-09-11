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
        'device_id', 'original_transaction_id', 'transaction_id',
        'purchase_token', 'receipt', 'currency', 'status',
        'purchased_at', 'expired_at'
    ];

    /**
     * Get device used for transaction.
     */
    public function device()
    {
        return $this->hasOne(Device::class, 'device_id');
    }

    /**
     * Get transactions of the device.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'transaction_id');
    }
}
