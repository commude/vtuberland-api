<?php

namespace App\Http\Resources\Screens;

use App\Http\Resources\PhotoResource;
use App\Http\Resources\CharacterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotCharacterResource extends JsonResource
{
    /**
     * Transform the spot resource into an array.
     *
     * @OA\Schema(
     *     schema="SpotCharacter",
     *     type="array",
     *     @OA\Items(
     *      @OA\Property(property="id",type="integer",format="int64",example=8),
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
        $spotCharacter = $this;
        $user = auth()->guard('user')->user();

        return [
            'id' => $spotCharacter->character_id,
            'name' => $spotCharacter->character->name,
            'image_url' => $spotCharacter->character->image_url,
            'video_url' => $spotCharacter->video_url,
            'is_purchased' => !is_null($user)
                                ? $user->spotCharacters->contains(function ($userSpotcharacter) use ($spotCharacter) {
                                        // Match if the user's list of SpotCharacter with the current SpotCharacter.
                                        return ($userSpotcharacter->character_id == $spotCharacter->character_id)
                                            && ($userSpotcharacter->spot_id == $spotCharacter->spot_id);
                                    })
                                : false,
            'created_at' => $spotCharacter->character->created_at,
        ];
    }
}
