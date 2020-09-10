<?php

namespace App\Http\Controllers\User\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\MeResource;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Exceptions\UserExistsException;
use App\Http\Requests\CreateUserRequest;
use App\Exceptions\UserNotFoundException;
use Illuminate\Support\Facades\Lang;

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
     *  @OA\Parameter(name="username",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="email",in="query",required=false,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="password",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="password_confirmation",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/User")),
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
            $user = User::where('username', $request->username)->first();

            if (!is_null($user)) {
                throw new UserExistsException();
            }

            $data = $request->data();
            $data['is_valid'] = true;
            event(new Registered($user = User::create($data)));

            return $user;
        });

        return new MeResource($user);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
