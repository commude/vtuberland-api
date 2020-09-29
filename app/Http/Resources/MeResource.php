<?php

namespace App\Http\Resources;

use App\Enums\MediaGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="User",
     *     @OA\Property(property="id",type="uuid",format="string",example="bdca9348-ccf2-49b7-9743-d17348876fe9"),
     *     @OA\Property(property="name",type="string",format="string",example="Takemoto Iwao"),
     *     @OA\Property(property="email",type="email",format="string",example="ultimate000@example.com"),
     *     @OA\Property(property="avatar",type="string",format="string",example="https://vtuberland.test/storage/users/2/95ceda61-0d8e-4866-81a0-182725f578fb.jpg"),
     *     @OA\Property(property="manufacturer",type="string",format="string",example="apple"),
     *     @OA\Property(property="os",type="string",format="string",example="iOS"),
     *     @OA\Property(property="version",type="string",format="string",example="1.0.0"),
     *     @OA\Property(property="language",type="string",format="string",example="ja_JP"),
     *     @OA\Property(property="is_valid",type="boolean",format="boolean",example=1),
     *     @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
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
            'email' => $this->email,
            'avatar' => ($this->hasMedia(MediaGroup::USERS['avatar']))
                            ? $this->getFirstMedia(MediaGroup::USERS['avatar'])->getFullUrl()
                            : null,
            'manufacturer' => $this->manufacturer,
            'os' => $this->os,
            'version' => $this->version,
            'language' => $this->language,
            'is_valid' => $this->is_valid,
            'created_at' => $this->created_at
        ];
    }
}
