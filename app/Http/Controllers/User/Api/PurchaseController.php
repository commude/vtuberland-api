<?php

namespace App\Http\Controllers\User\Api;

use Illuminate\Http\Request;
use App\Models\SpotCharacter;
use App\Models\UserSpotCharacter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\PurchaseNotFoundException;
use App\Http\Resources\Screens\PurchaseResource;
use App\Http\Resources\Screens\PurchaseViewResource;

class PurchaseController extends Controller
{
    /**
     * Fetch the current user.
     *
     * @return \Illuminate\Support\Facades\Auth
     */
    protected function guard()
    {
        return Auth::guard('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *  path="/purchases",
     *  tags={"Purchase"},
     *  security={{"passport": {"*"}}},
     *  summary="Get current purchases",
     *  description="Get current purchases of the user.",
     *  @OA\Parameter(name="per_page",in="query",required=false,
     *      @OA\Schema(type="integer"),),
     *  @OA\Parameter(name="page",in="query",required=false,
     *      @OA\Schema(type="integer"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/PurchaseViewScreen")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->guard()->user();

        if (!$user) {
            throw new UserNotFoundException();
        }

        $purchases = UserSpotCharacter::whereIn('id', $user->spotCharacters->pluck('id'))
                        ->latest()
                        ->paginate($request->query('per_page'));

        return PurchaseResource::collection($purchases);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *  path="/purchases/{user_spot_character_id}",
     *  tags={"Purchase"},
     *  security={{"passport": {"*"}}},
     *  summary="View Purchase screen.",
     *  description="View Purchase.",
     *  @OA\Parameter(name="user_spot_character_id",in="path",required=true,
     *      @OA\Schema(type="integer"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/PurchaseView")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Models\UserSpotCharacter  $user_spot_character
     * @return \Illuminate\Http\Response
     */
    public function show(UserSpotCharacter $user_spot_character)
    {
        $user = $this->guard()->user();

        if (!$user) {
            throw new UserNotFoundException;
        }

        if(!$user->spotCharacters->contains('id', $user_spot_character->id)){
            throw new PurchaseNotFoundException;
        };

        return new PurchaseViewResource($user_spot_character);
    }
}
