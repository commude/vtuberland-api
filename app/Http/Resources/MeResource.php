<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *  OA\Property(property="username",type="string",format="string",example="takemoto99999"),
     *  OA\Property(property="email",type="email",format="string",example="ultimate000@example.com"),
     *
     * @OA\Schema(
     *     schema="User",
     *     @OA\Property(property="id",type="uuid",format="string",example="bdca9348-ccf2-49b7-9743-d17348876fe9"),
     *     @OA\Property(property="name",type="string",format="string",example="Takemoto Iwao"),
     *     @OA\Property(property="email",type="email",format="string",example="ultimate000@example.com"),
     *     @OA\Property(property="manufacturer",type="string",format="string",example="apple"),
     *     @OA\Property(property="os",type="string",format="string",example="iOS"),
     *     @OA\Property(property="version",type="string",format="string",example="1.0.0"),
     *     @OA\Property(property="language",type="string",format="string",example="ja"),
     *     @OA\Property(property="token",type="string",format="string",example="dbGSQlj-BxE:APA91bFiWkfqJvCZeHleij1zKFMRY7UkcujCzRj6JplJor1HroSN-iTd1NtP-jF-pn0XqAoUNnq3pw_KW-rZtMuacsFzTcgqsoyd8LgNDCd2kmJW2DGsgjL5nfZyxvlZfzDzTrTMpGwN"),
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
            // 'username' => $this->username,
            'email' => $this->email,
            'manufacturer' => $this->manufacturer,
            'os' => $this->os,
            'version' => $this->version,
            'language' => $this->language,
            'token' => $this->token,
            'is_valid' => $this->is_valid,
            'created_at' => $this->created_at
        ];
    }
}
