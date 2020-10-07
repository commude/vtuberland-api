<?php

namespace App\Http\Controllers\User\Api;

use App\Models\Character;
use Illuminate\Http\Request;
use App\Models\SpotCharacter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UserNotFoundException;
use App\Http\Resources\Screens\ArchiveResource;
use App\Http\Resources\Screens\ArchiveViewResource;

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
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/SpotCharacterList")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found")
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\Screens\ArchiveResource
     */
    public function index(Request $request)
    {
        $spotCharacters = SpotCharacter::latest()->get();
        // $characters = ::paginate($request->query('per_page'));

        return ArchiveResource::collection($spotCharacters);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *  path="/characters/{spot_character_id}",
     *  tags={"Character"},
     *  security={{"passport": {"*"}}},
     *  summary="Get character details",
     *  description="View character screen.",
     *  @OA\Parameter(name="spot_character_id",in="path",required=true,
     *      @OA\Schema(type="integer"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/CharacterView")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Models\Character  $character
     * @return \App\Http\Resources\CharacterResource
     */
    public function show(SpotCharacter $spot_character)
    {
        $user = $this->guard()->user();

        if (!$user) {
            throw new UserNotFoundException;
        }

        return new ArchiveViewResource($spot_character);
    }
}
