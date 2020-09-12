<?php

namespace App\Http\Controllers\User\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CharacterResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Screens\ArchiveResource;
use App\Models\Character;
use App\Models\SpotCharacter;

class ArchiveController extends Controller
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
     *  path="/characters",
     *  tags={"Character"},
     *  security={{"passport": {"*"}}},
     *  summary="Get the list of characters",
     *  description="Archive screen.",
     *  @OA\Parameter(name="per_page",in="query",required=false,
     *      @OA\Schema(type="integer"),),
     *  @OA\Parameter(name="page",in="query",required=false,
     *      @OA\Schema(type="integer"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/ArchiveViewScreen")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found")
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $spotCharacters = SpotCharacter::latest()->paginate($request->query('per_page'));
        // $characters = ::paginate($request->query('per_page'));

        return ArchiveResource::collection($spotCharacters);
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
     *      @OA\Schema(type="string"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/SpotView")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Spot  $Spot
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        return new CharacterResource($character);
    }
}
