<?php

namespace App\Http\Resources\Screens;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="SpotView",
     *     @OA\Property(property="id",type="uuid",format="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *     @OA\Property(property="name",type="string",format="string",example="Roller Coaster"),
     *     @OA\Property(property="content",type="string",format="string"),
     *     @OA\Property(property="image_url",type="string",format="string", example="https://vtuberland.test/images/spots/rollercoaster.jpg"),
     *     @OA\Property(property="characters",ref="#/components/schemas/CharacterList"),
     *     @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
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
            'image_url' => $this->image_url,
            'characters' => CharacterListResource::collection($this->characters),
            'created_at' => $this->created_at
        ];
    }
}
