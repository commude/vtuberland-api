<?php

namespace App\Http\Resources;

use App\Enums\MediaGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="CharacterView",
     *     @OA\Property(property="id",type="integer",format="int64",example=8),
     *     @OA\Property(property="name",type="string",format="string",example="lion"),
     *     @OA\Property(property="content",type="string",format="string"),
     *     @OA\Property(property="image_url",type="string",format="string",example="https://vtuberland.test/images/characters/008-lion.png"),
     *     @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     * )
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
            'created_at' => $this->created_at,
        ];
    }
}
