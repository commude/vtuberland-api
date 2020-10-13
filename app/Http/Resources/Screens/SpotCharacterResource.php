<?php

namespace App\Http\Resources\Screens;

use App\Enums\Character;
use App\Utils\PriceUtils;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotCharacterResource extends JsonResource
{
    /**
     * Transform the spot resource into an array.
     *
     * @OA\Schema(
     *     schema="SpotCharacters",
     *     type="array",
     *     @OA\Items(
     *      @OA\Property(property="id",type="integer",format="int64",example=8),
     *      @OA\Property(property="name",type="string",format="string",example="鷹宮リオン"),
     *      @OA\Property(property="content",type="string",format="string"),
     *      @OA\Property(property="image_url",type="string",format="string",example="https://vtuberland.test/storage/characters/yumetsuki.png"),
     *      @OA\Property(property="video_url",type="string",format="string",example="https://youtu.be/WjoplqS1u18"),
     *      @OA\Property(property="is_purchased",type="boolean",format="boolean",example=true),
     *      @OA\Property(property="is_expired",type="boolean",format="boolean",example=false),
     *      @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="SpotCharacter",
     *     @OA\Property(property="id",type="integer",format="int64",example=8),
     *     @OA\Property(property="name",type="string",format="string",example="鷹宮リオン"),
     *     @OA\Property(property="content",type="string",format="string"),
     *     @OA\Property(property="image_url",type="string",format="string",example="https://vtuberland.test/storage/characters/yumetsuki.png"),
     *     @OA\Property(property="video_url",type="string",format="string",example="https://youtu.be/WjoplqS1u18"),
     *     @OA\Property(property="is_purchased",type="boolean",format="boolean",example=true),
     *     @OA\Property(property="is_expired",type="boolean",format="boolean",example=false),
     *     @OA\Property(property="created_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $spotCharacter = $this;
        $user = auth()->guard('user')->user();

        // Get the current Spot Character owned by user.
        if ($user) {
            $userSpotcharacter = $user->spotCharacters->where('spot_id', $spotCharacter->spot_id)
                                    ->where('character_id', $spotCharacter->character_id)
                                    ->sortByDesc('created_at')
                                    ->first();
        }

        return [
            'id' => $spotCharacter->character_id,
            'name' => Character::getJPName($spotCharacter->character->name),
            'content' => $spotCharacter->character->content,
            'image_url' => Storage::url($spotCharacter->character->image_path),
            'video_url' => $spotCharacter->video_url,
            'price' => ceil($spotCharacter->price), // PriceUtils::toWithoutTax(($spotCharacter->price)),
            'is_purchased' => !is_null($user)
                                ? !is_null($userSpotcharacter)
                                : false,
            'is_expired' => !is_null($user)
                                ? (!is_null($userSpotcharacter) ? Carbon::now()->gt($userSpotcharacter->expired_at) : false)
                                : false,
            'created_at' => $spotCharacter->character->created_at,
        ];
    }
}
