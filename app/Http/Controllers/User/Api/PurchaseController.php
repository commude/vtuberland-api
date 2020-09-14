<?php

namespace App\Http\Controllers\User\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\UserNotFoundException;

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
     * Generate new session of the user.
     *
     * @OA\Post(
     *  path="/purchase",
     *  tags={"Purchase"},
     *  security={{"passport": {"*"}}},
     *  summary="Purchase an item from store.",
     *  description="Purchase an item from store.",
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/Auth")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request)
    {
        $user = $this->guard()->user();

        if (!$user) {
            throw new UserNotFoundException();
        }

        // return new AuthResource($userToken);
    }
}
