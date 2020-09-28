<?php

namespace App\Http\Resources;

use App\Enums\Character;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="Character",
     *     @OA\Property(property="id",type="uuid",format="string",example="06762a4e-bb7c-4715-b30e-0f4b3ce77e40"),
     *     @OA\Property(property="name",type="string",format="string",example="鷹宮リオン"),
     *     @OA\Property(property="content",type="string",format="string"),
     *     @OA\Property(property="image_url",type="string",format="string",example="https://vtuberland.test/storage/characters/yumetsuki.png"),
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
            'image_url' =>  Storage::url($this->image_path),
        ];
    }
}
