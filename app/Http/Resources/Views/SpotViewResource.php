<?php

namespace App\Http\Resources\Views;

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
            'id' => $this->uuid,
            'title' => $this->title,
            'content' => $this->content,
            'characters' => $this->characters(),
            'created_at' => $this->created_at
        ];
    }
}
