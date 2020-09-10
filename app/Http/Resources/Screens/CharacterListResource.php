<?php

namespace App\Http\Resources\Screens;

use App\Http\Resources\PhotoResource;
use App\Http\Resources\CharacterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterListResource extends JsonResource
{
    /**
     * Transform the spot resource into an array.
     *
     * @OA\Schema(
     *     schema="CharacterList",
     *     type="array",
     *     @OA\Items(
     *      @OA\Property(property="id",type="uuid",format="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *      @OA\Property(property="name",type="string",format="string",example="lion"),
     *      @OA\Property(property="image_url",type="string",format="string",example="https://vtuberland.test/images/characters/008-lion.png"),
     *      @OA\Property(property="video_url",type="string",format="string",example="https://youtu.be/WjoplqS1u18"),
     *      @OA\Property(property="is_purchased",type="boolean",format="boolean",example=true),
     *      @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth()->guard('user')->user();

        return [
            'id' => $this->character->id,
            'name' => $this->character->name,
            'image_url' => $this->character->image_url,
            'video_url' => $this->video_url,
            'is_purchased' => true, //$user->characters->contains('character_id', $this->id),
            'created_at' => $this->character->created_at,
        ];
    }
}
