<?php

namespace App\Http\Controllers\User\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UserNotFoundException;

class AuthController extends Controller
{
    /**
     * Create a session of the user.
     *
     * @OA\Post(
     *  path="/auth/login",
     *  tags={"Auth"},
     *  security={{"passport": {"*"}}},
     *  summary="Login User",
     *  description="User Login",
     *  @OA\Parameter(name="email",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="password",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/Auth")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \App\Http\Resources\AuthResource
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->data())){
            throw new UserNotFoundException;
        }

        $userToken = $request->user()->createToken('VTuberland Password Grant Client');
        $token = $userToken->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        return new AuthResource($userToken);
    }
}
