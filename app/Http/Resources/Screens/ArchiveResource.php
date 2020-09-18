<?php

namespace App\Http\Resources\Screens;

use App\Http\Resources\SpotResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArchiveResource extends JsonResource
{
    /**
     * Transform the spot resource into an array.
     *
     * @OA\Schema(
     *  schema="ArchiveViewScreen",
     *  type="array",
     *  @OA\Items(
     *   @OA\Property(property="data",ref="#/components/schemas/SpotCharacterList"),
     *   @OA\Property(property="links",ref="#/components/schemas/links"),
     *   @OA\Property(property="meta",ref="#/components/schemas/meta")
     *  ),
     * )
     *
     * @OA\Schema(
     *     schema="SpotCharacterList",
     *     type="array",
     *     @OA\Items(
     *      @OA\Property(property="id",type="integer",format="int64",example=1),
     *      @OA\Property(property="spot",ref="#/components/schemas/Spot"),
     *      @OA\Property(property="characters",ref="#/components/schemas/SpotCharacter"),
     *     )
     * )
     *
     * OA\Schema(
     *     schema="SpotArchiveView",
     *     OA\Property(property="id",type="uuid",format="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *     OA\Property(property="name",type="string",format="string",example="Roller Coaster"),
     *     OA\Property(property="beacon_id",type="uuid",format="string",example="d3aacc6a-f618-3b19-b63f-8ab5e804e495"),
     *     OA\Property(property="created_at",type="string",format="string"),
     * )
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'spot' => new SpotResource($this->spot),
            'characters' => SpotCharacterResource::collection($this->spot->characters->sortByDesc('created_at')),
        ];
    }
}
