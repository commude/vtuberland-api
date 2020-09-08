<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
            'os' => $this->os,
            'version' => $this->version,
            'language' => $this->language,
            'key' => $this->key,
            'created_at' => $this->created_at
        ];
    }
}
