<?php

namespace App\Http\Resources;

use App\Enums\MediaGroup;
use App\Enums\Spot;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="Spot",
     *     @OA\Property(property="id",type="uuid",format="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *     @OA\Property(property="name",type="string",format="string",example="アニマルレスキュー"),
     *     @OA\Property(property="content",type="string",format="string"),
     *     @OA\Property(property="image_url",type="uuid",format="string",example="https://vtuberland.test/storage/spots/7/jWCkOYpSWmaoCKxWaTVZCtUxf.jpg"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => Spot::getJPName($this->name),
            'content' => $this->content,
            'image_url' => $this->getFirstMedia(MediaGroup::SPOTS['main'])->getFullUrl(),
        ];
    }
}
