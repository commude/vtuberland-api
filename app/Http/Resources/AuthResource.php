<?php

namespace App\Http\Resources;

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
            'token_type' => $this['token_type'],
            'token' => $this['access_token'],
            'refresh_token' => $this['refresh_token'] ?? ''
        ];
    }
}
