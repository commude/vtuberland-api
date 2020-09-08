<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Schema(
     *     schema="Auth",
     *     @OA\Property(property="access_token",type="string",format="string",example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5MTc4ZDY4NC0yYWFkLTRkNjItODQ0Yi0zZTNlZDJjZDZlOTIiLCJqdGkiOiI2NDgyY2YzZjQ5MjA3OTA1YjM2ZDc2YWZlOGM5YWRmYTk0M2MwMzBlNjRmMGU3YjhjZjcwMDNmNWUwM2MyMDYxZjJkNTc4NTMyOGI2NDA5MyIsImlhdCI6MTU5OTQ4Mzg4OCwibmJmIjoxNTk5NDgzODg4LCJleHAiOjE2MzEwMTk4ODgsInN1YiI6ImJkY2E5MzQ4LWNjZjItNDliNy05NzQzLWQxNzM0ODg3NmZlOSIsInNjb3BlcyI6W119.N8owVNbUQNpUREfRHoalOV-FLVbGFURBZ_Ez9eyaiItM8tg1qJZ5PhRrGIaUvTyhEHzoqoa9EMhqvfamrbpghx7tAJscS-Xd1CM2nh0g-3LetKXHvvwbYGQ3D8nw5hlfwLlSHfx-YlH6WN4sDjT36rdbc5IG0Qxdn7GN8JQu3bJWDguzcbiuyiph-VS-0smankid4h7oo1siFEuS96X-7E2-SN6qm4s0v7M_IEb9rL9iMTp0mdU4KG9ZFj31C6wdGo0uotT7osdQ43nEJak6cxNNys8NMhn46YqQw2VFG4fYdXYbQ8o7Gqj8aqDRo5oLKcVBXc4fPRVq6tbnVkogUoZxDCfVMS6AWYthbEnd2Y7R12vP53ZPQ1MDNM-n3Px8syaj8ovx3thfZy6dsdH914qCHqo3nfyxWZo6TXegDqeAGhAB1cDnU-fk6NwEmp1HzKVEJaoW8MxDIMVYG8cbd0SViT7pX6LVJUPe9LIDEVaTdLB_Oek2eXht51DXv26WWvaZpRbZd9aLmoM5krceBFvy-z8WXwRVaSKOFBxZgNR5Avnp2a5CJVvDGKFZ2r_8otr4WD04qxBIc16ystzJMeDtFyyZRpaSHMl2ehhaEAbAXvzU7jCmvzHbUzAo_8W_BJiI4IZkSrwrgSQUWVgP2W1kS1fA8jul37-opNWOeIE"),
     *     @OA\Property(property="token_type",type="string",format="string",example="Bearer"),
     *     @OA\Property(property="expires_at",type="timestamp",format="date",example="2020-03-10T19:42:31+09:00")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'access_token' => $this->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($this->token->expires_at)->toDateTimeString()
        ];
    }
}
