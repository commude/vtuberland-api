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
     *  @OA\Property(property="data",ref="#/components/schemas/SpotCharacterList"),
     *  @OA\Property(property="links",ref="#/components/schemas/links"),
     *  @OA\Property(property="meta",ref="#/components/schemas/meta")
     * )
     *
     * @OA\Schema(
     *     schema="SpotCharacterList",
     *     type="array",
     *     @OA\Items(
     *      @OA\Property(property="Roller Coaster",ref="#/components/schemas/SpotCharacter"),
     *     )
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
            'created_at' => $this->created_at
        ];
    }
}
