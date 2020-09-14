<?php

namespace App\Http\Controllers\Admin\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Exceptions\UserNotFoundException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        try {
            if ($this->attemptLogin($request)) {
                $request->session()->regenerate();

                $this->clearLoginAttempts($request);

                return redirect()->route('admin.purchase.index');
            } else {
                throw new UserNotFoundException();
            }
        } catch (UserNotFoundException $e) {
            return back()->withErrors(['password' => 'ID、またはパスワードが違います。'])->withInput($request->only('email'));
        }

        return back();
    }
}
