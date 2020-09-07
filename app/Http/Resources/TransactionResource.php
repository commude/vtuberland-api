<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'device_id' => $this->device_id,
            'original_transaction_id' => $this->original_transaction_id,
            'transaction_id' => $this->transaction_id,
            'purchase_token' => $this->purchase_token,
            'receipt' => $this->receipt,
            'currency' => $this->currency,
            'status' => $this->status,
            'purchased_at' => $this->purchased_at,
            'expired_at' => $this->expired_at,
            'created_at' => $this->created_at
        ];
    }
}
