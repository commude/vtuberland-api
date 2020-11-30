<?php

namespace App\Http\Controllers\User\Api;

use App\Models\User;
use App\Enums\MediaGroup;
use Illuminate\Support\Str;
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
use App\Http\Requests\UpdateUserRequest;
use App\Exceptions\UserNotFoundException;
use App\Notifications\MailResetPassword;
use Illuminate\Support\Facades\Validator;

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
     * @return \App\Http\Resources\MeResource
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
     *  @OA\Parameter(name="password",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="password_confirmation",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="avatar",in="query",required=false,
     *      @OA\Schema(type="file"),),
     *  @OA\Parameter(name="manufacturer",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="os",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="version",in="query",required=false,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="language",in="query",required=false,
     *      @OA\Schema(type="string"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/Auth")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @param  \App\Http\Requests\CreateUserRequest  $request
     * @return \App\Http\Resources\AuthResource
     */
    public function register(CreateUserRequest $request)
    {
        $user = DB::transaction(function () use ($request) {
            $data = $request->data();
            $data['is_valid'] = true;

            event(new Registered($user = User::create($data)));

            if($request->has('avatar')){
                $userPhoto = $user->addMediaFromRequestUsingUuid('avatar')
                    ->toMediaCollection(MediaGroup::USERS['avatar'], 'users');
            }

            return $user;
        });

        $userToken = $user->createToken('VTuberland Password Grant Client');

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

    /**
     * Generate new session of the user.
     *
     * @OA\Post(
     *  path="/me/refresh",
     *  tags={"Me"},
     *  security={{"passport": {"*"}}},
     *  summary="Refresh user session.",
     *  description="Revoke and Generate new user session.",
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/Auth")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @return \App\Http\Resources\AuthResource
     */
    public function refresh()
    {
        $user = $this->guard()->user();

        if (!$user) {
            throw new UserNotFoundException();
        }

        $user->token()->revoke();
        $userToken = $user->createToken('VTuberland Password Grant Client');

        return new AuthResource($userToken);
    }

    /**
     * Update user profile
     *
     * @OA\Post(
     *  path="/me/update",
     *  tags={"Me"},
     *  security={{"passport": {"*"}}},
     *  summary="Update User",
     *  description="Update existing user.",
     *  @OA\Parameter(name="email",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="old_password",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="password",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="password_confirmation",in="query",required=true,
     *      @OA\Schema(type="string"),),
     *  @OA\Parameter(name="avatar",in="query",required=false,
     *      @OA\Schema(type="file"),),
     *  @OA\Response(response=200,description="Successful operation",@OA\JsonContent(ref="#/components/schemas/User")),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     * @return \App\Http\Resources\MeResource
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $this->guard()->user();
        $user->fill($request->data());
        $user->save();

        // Validate and delete current image to replace new image.
        if($request->has('avatar')){
            if($user->hasMedia(MediaGroup::USERS['avatar'])){
                $user = $user->clearMediaCollection(MediaGroup::USERS['avatar']);
            }

            $userPhoto = $user->addMediaFromRequestUsingUuid('avatar')->toMediaCollection(MediaGroup::USERS['avatar'], 'users');
        }

        return new MeResource($user);
    }

    /**
     * Request for a new Password.
     *
     * @OA\Post(
     *  path="/forgot-password",
     *  tags={"Me"},
     *  summary="Forgot Password User",
     *  description="Generate new password to user.",
     *  @OA\Parameter(name="email",in="query",required=true,
     *      @OA\Schema(type="string"),),
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
    public function forgotPassword(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'email' => ['required', 'exists:users,email']
        ]);

        if ($validate->fails()){
            return response()->json($validate->errors()->getMessages(), 405);
        }

        // Generate random password.
        $password = Str::random(8);

        // Get user details.
        $user = User::firstWhere('email', $request->email);

        $user = $user->fill([
            'password' => $password
        ]);

        $user->save();

        // Send Email Notification
        $user->notify(new MailResetPassword($password));


        return response()->json([
            'code' => 200,
            'message' => 'ユーザーは正常にログアウトしました'
        ], 200);
    }
}
