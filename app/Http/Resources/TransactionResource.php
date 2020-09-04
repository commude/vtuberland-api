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
            'id' => $request->uuid,
            'device_id' => $request->device_id,
            'original_transaction_id' => $request->original_transaction_id,
            'transaction_id' => $request->transaction_id,
            'purchase_token' => $request->purchase_token,
            'receipt' => $request->receipt,
            'currency' => $request->currency,
            'status' => $request->status,
            'purchased_at' => $request->purchased_at,
            'expired_at' => $request->expired_at,
            'created_at' => $request->created_at
        ];
    }
}
