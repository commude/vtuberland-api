<?php

namespace App\Http\Resources\Screens;

use App\Enums\Spot;
use App\Enums\Character;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the spot resource into an array.
     *
     * @OA\Schema(
     *  schema="PurchaseViewScreen",
     *  @OA\Property(property="data",ref="#/components/schemas/PurchaseList"),
     *  @OA\Property(property="links",ref="#/components/schemas/links"),
     *  @OA\Property(property="meta",ref="#/components/schemas/meta")
     * )
     *
     * @OA\Schema(
     *     schema="PurchaseList",
     *     type="array",
     *     @OA\Items(
     *      @OA\Property(property="id",type="integer",format="int64",example=1),
     *      @OA\Property(property="spot",ref="#/components/schemas/SpotBase"),
     *      @OA\Property(property="character",ref="#/components/schemas/CharacterBase"),
     *      @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="SpotBase",
     *     @OA\Property(property="id",type="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *     @OA\Property(property="name",type="string",example="大観覧車"),
     * )
     *
     * @OA\Schema(
     *     schema="CharacterBase",
     *     @OA\Property(property="id",type="string",example="06762a4e-bb7c-4715-b30e-0f4b3ce77e40"),
     *     @OA\Property(property="name",type="string",example="鷹宮リオン"),
     *     @OA\Property(property="image_url",type="string",format="string",example="https://vtuberland.test/storage/characters/yumetsuki.png")
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'spot' => [
                'id' => $this->spot->id,
                'name' => Spot::getJPName($this->spot->name)
            ],
            'character' => [
                'id' => $this->character->id,
                'name' => Character::getJPName($this->character->name),
                'image_url' => Storage::url($this->character->image_path),
            ],
            'created_at' => $this->created_at
        ];
    }
}
