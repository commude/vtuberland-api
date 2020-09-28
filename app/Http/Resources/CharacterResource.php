<?php

namespace App\Http\Resources;

use App\Enums\Character;
use App\Enums\MediaGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="Character",
     *     @OA\Property(property="id",type="uuid",format="string",example="09d676d4-039f-49eb-98eb-773f08b4d2fb"),
     *     @OA\Property(property="name",type="string",format="string",example="鷹宮リオン"),
     *     @OA\Property(property="content",type="string",format="string"),
     *     @OA\Property(property="image_url",type="string",format="string",example="https://vtuberland.test/storage/characters/takamiya.png"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => Character::getJPName($this->name),
            'content' => $this->content,
            'image_url' => $this->image_url,
        ];
    }
}
