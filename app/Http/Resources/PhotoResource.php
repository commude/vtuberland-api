<?php

namespace App\Http\Resources;

use App\Enums\PhotoSize;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
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
            'original' => new PhotoDetailsResource($this),
            'small' => new PhotoDetailsResource($this, PhotoSize::SMALL),
            'medium' => new PhotoDetailsResource($this, PhotoSize::MEDIUM),
            'large' => new PhotoDetailsResource($this, PhotoSize::LARGE),
        ];
    }
}
