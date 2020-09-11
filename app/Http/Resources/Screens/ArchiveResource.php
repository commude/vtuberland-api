<?php

namespace App\Http\Resources\Screens;

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
     *      @OA\Property(property="spot",ref="#/components/schemas/SpotArchiveView"),
     *      @OA\Property(property="characters",ref="#/components/schemas/SpotCharacter"),
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="SpotArchiveView",
     *     @OA\Property(property="id",type="uuid",format="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *     @OA\Property(property="name",type="string",format="string",example="Roller Coaster"),
     *     @OA\Property(property="beacon_id",type="uuid",format="string",example="d3aacc6a-f618-3b19-b63f-8ab5e804e495"),
     *     @OA\Property(property="created_at",type="string",format="string"),
     * )
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $user = auth()->guard('user')->user();
        // dd($this->spot->characters);
        return [
            'spot' => [
                'id' => $this->spot->id,
                'name' => $this->spot->name,
                'beacon_id' => $this->spot->beacon_id,
                'created_at' => $this->spot->created_at,
            ],
            'characters' => SpotCharacterResource::collection($this->spot->characters),
        ];
    }
}
