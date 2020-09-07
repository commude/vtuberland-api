<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            'access_token' => $this->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($this->token->expires_at)->toDateTimeString()
        ];
    }
}
