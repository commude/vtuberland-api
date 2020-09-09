<?php

namespace App\Http\Controllers\User\Api;

use App\Models\Spot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SpotResource;
use App\Http\Resources\Views\SpotViewResource;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Spot = Spot::all();

        return SpotResource::collection($Spot);
    }

    /**
     * Display the specified resource.
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function characters(Request $request)
    {
        $user = $this->guard()->user();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Spot  $Spot
     * @return \Illuminate\Http\Response
     */
    public function showCharacter(Spot $Spot)
    {
        $user = $this->guard()->user();
    }
}
