<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use GuzzleHttp\Client as GuzzleClient;
use App\Exceptions\UserNotFoundException;

class AuthController extends Controller
{
    /**
     * Create a session of the user.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->first();

        if (is_null($user)){
            throw new UserNotFoundException;
        }

        $http = new GuzzleClient;
        $response = $http->post(config('services.passport.login_endpoint'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $user->client->id,
                'client_secret' => $user->client->secret,
                'username' => $user->username,
                'password' => $request->password,
                'scope' => '*',
            ],
        ]);

        $result = json_decode((string) $response->getBody(), true);
        return new AuthResource($result);
    }

    /**
     * Generate new session of the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request, $id)
    {
        //
    }
}
