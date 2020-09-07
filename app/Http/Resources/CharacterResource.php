<?php

namespace App\Http\Resources;

use App\Enums\MediaGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
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
            'main_photo' => new PhotoResource($this->getFirstMedia(MediaGroup::CHARACTERS['main'])),
        ];
    }
}
