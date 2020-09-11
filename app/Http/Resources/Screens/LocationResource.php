<?php

namespace App\Http\Resources\Screens;

use App\Http\Resources\CharacterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the spot resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'beacon_id' => $this->beacon_id,
            'location' => $this->location,
            'character' => new CharacterResource($this->character()),
            'created_at' => $this->created_at
        ];
    }
}
