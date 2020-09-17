<?php

namespace App\Http\Controllers\User\Api;

use App\Models\Spot;
use App\Enums\Status;
use App\Models\Purchase;
use App\Models\Character;
use Illuminate\Http\Request;
use App\Models\UserSpotCharacter;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpotResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\PurchaseService;
use App\Http\Resources\PurchaseResource;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\CreatePurchaseRequest;
use App\Http\Resources\Screens\HomeResource;
use App\Http\Resources\Screens\SpotViewResource;
use App\Http\Resources\Screens\SpotCharacterResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     *  @OA\Parameter(name="spot_id",in="path",required=true,
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
     *  @OA\Parameter(name="spot_id",in="path",required=true,
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
     *  @OA\Parameter(name="spot_id",in="path",required=true,
     *      @OA\Schema(type="uuid"),),
     * @OA\Parameter(name="character_id",in="path",required=true,
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

    /**
     * Generate new session of the user.
     *
     * @OA\Post(
     *  path="/spots/{spot_id}/characters/{character_id}/purchase",
     *  tags={"Spot"},
     *  security={{"passport": {"*"}}},
     *  summary="Purchase an item from store.",
     *  description="Purchase an item from store.",
     *  @OA\Parameter(name="spot_id",in="path",required=true,
     *      @OA\Schema(type="uuid"),),
     *  @OA\Parameter(name="character_id",in="path",required=true,
     *      @OA\Schema(type="integer"),),
     *  @OA\Parameter(name="app",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="receipt",in="query",required=false,
     *      @OA\Schema(type="string"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/Auth")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function purchase(CreatePurchaseRequest $request, Spot $spot, Character $character, PurchaseService $service)
    {
        $user = $this->guard()->user();

        if (!$user) {
            throw new UserNotFoundException();
        }

        $transaction = $service->verify($request->data(), $user);

        // Save the current purchase details.
        $purchase = Purchase::create(array_merge($transaction, [
            'user_id' => $user->id
        ]));

        // Store user owned spot character.
        if ($purchase->status == Status::OK){
            UserSpotCharacter::create([
                'user_id' => $user->id,
                'spot_id' => $spot->id,
                'character_id' => $character->id,
            ]);
        } else{
            DB::table('failed_purchases')->insert([
                'purchase_id' => $purchase->id,
                'user_id' => $user->id,
                'spot_id' => $spot->id,
                'character_id' => $character->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return new PurchaseResource($purchase);
    }
}
