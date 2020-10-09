<?php

namespace App\Http\Resources\Screens;

use App\Enums\Spot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotResource extends JsonResource
{
    /**
     * Transform the spot resource into an array.
     *
     * @OA\Schema(
     *  schema="HomeViewScreen",
     *  @OA\Property(property="data",ref="#/components/schemas/SpotList"),
     *  @OA\Property(property="links",ref="#/components/schemas/links"),
     *  @OA\Property(property="meta",ref="#/components/schemas/meta")
     * )
     *
     * @OA\Schema(
     *     schema="SpotList",
     *     type="array",
     *     @OA\Items(
     *      @OA\Property(property="id",type="uuid",format="string",example="26397745-9126-438c-9706-5002baf5d3a4"),
     *      @OA\Property(property="order",type="integer",example=1),
     *      @OA\Property(property="name",type="string",format="string",example="大観覧車"),
     *      @OA\Property(property="beacon_id",type="uuid",format="string",example="d3aacc6a-f618-3b19-b63f-8ab5e804e495"),
     *      @OA\Property(property="image_url",format="string",example="https://vtuberland.test/storage/spots/ferris_wheel.jpg"),
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
            'order' => $this->order,
            'name' => Spot::getJPName($this->name),
            'beacon_id' => $this->beacon_id,
            'image_url' => Storage::url($this->image_path),
            'created_at' => $this->created_at
        ];
    }
}
