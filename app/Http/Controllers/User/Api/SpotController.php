<?php

namespace App\Http\Controllers\User\Api;

use App\Models\Spot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Screens\HomeResource;
use App\Http\Resources\Screens\SpotCharacterResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SpotResource;
use App\Http\Resources\Screens\SpotViewResource;
use App\Models\Character;

class SpotController extends Controller
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
     *  path="/spots",
     *  tags={"Spot"},
     *  security={{"passport": {"*"}}},
     *  summary="Get the list of spots",
     *  description="Home screen.",
     *  @OA\Parameter(name="per_page",in="query",required=false,
     *      @OA\Schema(type="integer"),),
     *  @OA\Parameter(name="page",in="query",required=false,
     *      @OA\Schema(type="integer"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/HomeViewScreen")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $spot = Spot::paginate($request->query('per_page'));

        return HomeResource::collection($spot);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *  path="/spots/{spot_id}",
     *  tags={"Spot"},
     *  security={{"passport": {"*"}}},
     *  summary="Get the list of spots",
     *  description="View Spot Screen with characters.",
     *  @OA\Parameter(name="spot_id",in="query",required=true,
     *      @OA\Schema(type="uuid"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/SpotView")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Spot  $Spot
     * @return \Illuminate\Http\Response
     */
    public function show(Spot $Spot)
    {
        return new SpotViewResource($Spot);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *  path="/spots/{spot_id}/characters",
     *  tags={"Spot"},
     *  security={{"passport": {"*"}}},
     *  summary="Get the character list of the spot.",
     *  description="Get the character list of the spot.",
     *  @OA\Parameter(name="spot_id",in="query",required=true,
     *      @OA\Schema(type="uuid"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/SpotCharacters")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Models\Spot  $Spot
     * @return \Illuminate\Http\Response
     */
    public function characters(Spot $spot)
    {
        return SpotCharacterResource::collection($spot->characters);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *  path="/spots/{spot_id}/characters/{character_id}",
     *  tags={"Spot"},
     *  security={{"passport": {"*"}}},
     *  summary="Get the character of the spot.",
     *  description="Get the character of the spot.",
     *  @OA\Parameter(name="spot_id",in="query",required=true,
     *      @OA\Schema(type="uuid"),),
     * @OA\Parameter(name="character_id",in="query",required=true,
     *      @OA\Schema(type="integer"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/SpotCharacter")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     * @param  \App\Models\Spot  $Spot
     * @return \Illuminate\Http\Response
     */
    public function showCharacter(Spot $spot, Character $character)
    {
        $spotCharacter = $spot->characters->where('character_id', $character->id)->first();

        return new SpotCharacterResource($spotCharacter);
    }
}
