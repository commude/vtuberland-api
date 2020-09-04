<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttractionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $request->uuid,
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'location' => $request->location,
            'created_at' => $request->created_at
        ];
    }
}
