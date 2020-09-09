<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpotResource extends JsonResource
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
            'id' => $this->id,
            'beacon_id' => $this->beacon_id,
            'name' => $this->name,
            'content' => $this->content,
            'location' => json_decode($this->location),
            'created_at' => $this->created_at
        ];
    }
}
