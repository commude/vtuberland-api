<?php

namespace App\Http\Resources\Screens;

use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CharacterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArchiveViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="CharacterView",
     *     @OA\Property(property="id",type="integer",format="int64",example=1),
     *     @OA\Property(property="character",ref="#/components/schemas/Character"),
     *     @OA\Property(property="video_url",type="string",format="string",example="https://youtu.be/WjoplqS1u18"),
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
            'character' => new CharacterResource($this->character),
            'video_url' => Storage::url($this->video_url),
            'created_at' => $this->created_at,
        ];
    }
}
