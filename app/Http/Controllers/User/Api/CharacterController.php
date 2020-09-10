<?php

namespace App\Http\Controllers\User\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Screens\ArchiveResource;

class CharacterController extends Controller
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
        // $characters = ::paginate($request->query('per_page'));

        // return ArchiveResource::collection($spot);
    }
}
