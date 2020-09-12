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
        $user = auth()->guard('user')->user();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content,
            'image_url' => $this->image_url,
        ];
    }
}
