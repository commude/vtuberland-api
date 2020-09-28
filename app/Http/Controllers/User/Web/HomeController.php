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
        dd(Storage::path('characters'), config('filesystems.disks.characters.root'));
        return view('user.welcome');
    }
}
