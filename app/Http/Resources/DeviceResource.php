<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="Device",
     *     type="array",
     *     @OA\Property(property="id",type="uuid",format="string",example="bdca9348-ccf2-49b7-9743-d17348876fe9"),
     *     @OA\Property(property="name",type="string",format="string",example="Takemoto Iwao"),
     *     @OA\Property(property="manufacturer",type="string",format="string",example="takemoto99999"),
     *     @OA\Property(property="os",type="email",format="string",example="ultimate000@example.com"),
     *     @OA\Property(property="version",type="boolean",format="boolean",example="true"),
     *     @OA\Property(property="language",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     *     @OA\Property(property="key",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     *     @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'manufacturer' => $this->manufacturer,
            'os' => $this->os,
            'version' => $this->version,
            'language' => $this->language,
            'key' => $this->key,
            'created_at' => $this->created_at
        ];
    }
}
