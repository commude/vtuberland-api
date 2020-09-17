<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('user.welcome');
    }
}
