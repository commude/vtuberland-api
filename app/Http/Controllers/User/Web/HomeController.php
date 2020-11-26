<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Display privacy page.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        return view('user.privacy');
    }

    /**
     * Display privacy app page.
     *
     * @return \Illuminate\Http\Response
     */
    public function appPrivacy()
    {
        return view('user.privacy_app');
    }
}
