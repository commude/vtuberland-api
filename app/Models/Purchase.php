<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use ScopeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'original_transaction_id', 'transaction_id',
        'purchase_token', 'receipt', 'currency', 'status',
        'purchased_at', 'expired_at', 'exception_message'
    ];

    /**
     * Get user owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
