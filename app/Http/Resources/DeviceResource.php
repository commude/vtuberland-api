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
            'id' => $request->uuid,
            'name' => $request->name,
            'manufacturer' => $request->manufacturer,
            'os' => $request->os,
            'version' => $request->version,
            'language' => $request->language,
            'key' => $request->key,
            'created_at' => $request->created_at
        ];
    }
}
