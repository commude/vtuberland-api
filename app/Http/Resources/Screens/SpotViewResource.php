<?php

namespace App\Http\Resources\Screens;

use App\Http\Resources\CharacterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotViewResource extends JsonResource
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
            'name' => $this->name,
            'content' => $this->content,
            'image_url' => $this->image_url,
            'characters' => CharacterResource::collection($this->characters),
            'created_at' => $this->created_at
        ];
    }
}
