<?php

namespace App\Http\Resources\Screens;

use App\Http\Resources\SpotResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="PurchaseView",
     *     @OA\Property(property="spot",type="string",ref="#/components/schemas/Spot"),
     *     @OA\Property(property="characters",ref="#/components/schemas/SpotCharacters"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userSpotCharacters = $this->user->spotCharacters->where('spot_id', $this->spot_id)->pluck('character_id');

        return [
            'spot' => new SpotResource($this->spot),
            'characters' => SpotCharacterResource::collection($this->spot->characters->whereIn('character_id', $userSpotCharacters)),
        ];
    }
}
