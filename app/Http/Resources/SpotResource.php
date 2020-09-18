<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="Spot",
     *     @OA\Property(property="id",type="uuid",format="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *     @OA\Property(property="name",type="string",format="string",example="Roller Coaster"),
     *     @OA\Property(property="content",type="string",format="string"),
     *     @OA\Property(property="image_url",type="uuid",format="string",example="https://vtuberland.test/images/spots/rollercoaster.jpg"),
     * )
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
            // 'beacon_id' => $this->beacon_id,
            'image_url' => $this->image_url,
        ];
    }
}
