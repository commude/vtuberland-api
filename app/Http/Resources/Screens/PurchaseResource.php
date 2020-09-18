<?php

namespace App\Http\Resources\Screens;

use Illuminate\Support\Carbon;
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
     *      @OA\Property(property="spot",type="string",ref="#/components/schemas/Spot"),
     *      @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     *     )
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
            'created_at' => $this->created_at
        ];
    }
}
