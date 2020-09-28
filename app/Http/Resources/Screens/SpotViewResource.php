<?php

namespace App\Http\Resources\Screens;
use App\Enums\MediaGroup;
use App\Enums\Spot;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SpotViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="SpotView",
     *     @OA\Property(property="id",type="uuid",format="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *     @OA\Property(property="name",type="string",format="string",example="ハシビロGO！"),
     *     @OA\Property(property="content",type="string",format="string"),
     *     @OA\Property(property="image_url",type="string",format="string", example="https://vtuberland.test/storage/spots/hashiboro_go.jpg"),
     *     @OA\Property(property="characters",ref="#/components/schemas/SpotCharacters"),
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
            'name' => Spot::getJPName($this->name),
            'content' => $this->content,
            'image_url' => Storage::url($this->image_path),
            'characters' => SpotCharacterResource::collection($this->characters),
            'created_at' => $this->created_at
        ];
    }
}
