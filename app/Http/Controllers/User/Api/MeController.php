<?php

namespace App\Http\Controllers\User\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\MeResource;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Events\Registered;
use App\Exceptions\UserExistsException;
use App\Http\Requests\CreateUserRequest;
use App\Exceptions\UserNotFoundException;

class MeController extends Controller
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
     *  path="/me",
     *  tags={"Me"},
     *  security={{"passport": {"*"}}},
     *  summary="Get current user",
     *  description="Get current details of the user.",
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/User")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->guard()->user();

        if (!$user) {
            throw new UserNotFoundException();
        }

        return new MeResource($user);
    }

    /**
     * Register a newly created user.
     *
     * @OA\Post(
     *  path="/me",
     *  tags={"Me"},
     *  security={{"passport": {"*"}}},
     *  summary="Register User",
     *  description="Create a new user.",
     *  @OA\Parameter(name="name",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="email",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="manufacturer",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="os",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="version",in="query",required=false,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="language",in="query",required=false,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="token",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/Auth")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(CreateUserRequest $request)
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::where('email', $request->email)->first();

            if (!is_null($user)) {
                // throw new UserExistsException();
                return $user;
            }

            $data = $request->data();
            $data['is_valid'] = true;

            event(new Registered($user = User::create($data)));

            return $user;
        });

        $userToken = $user->createToken('Laravel Password Grant Client');

        // return new MeResource($user);
        return new AuthResource($userToken);
    }

    /**
     * Revoke active token of the current user.
     *
     * @OA\Post(
     *  path="/me/logout",
     *  tags={"Me"},
     *  security={{"passport": {"*"}}},
     *  summary="Logout User",
     *  description="Revoke the current session of user.",
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(
     *      @OA\Property(property="code",type="integer",format="integer",example=200),
     *      @OA\Property(property="message",type="text",format="string",example="ユーザーは正常にログアウトしました"))),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = $this->guard()->user();

        if (!$user) {
            throw new UserNotFoundException();
        }

        $user->token()->revoke();

        return response()->json([
            'code' => 200,
            'message' => Lang::get('auth.logout')
        ]);
    }
}
