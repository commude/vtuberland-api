<?php

namespace App\Http\Controllers\Admin\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Exceptions\UserNotFoundException;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    const SESSION_KEY = 'registration_form';

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
    public function index(Request $request)
    {
        $input = ['email'=>'', 'password'=>''];
        if (Session::has(self::SESSION_KEY)) {
            $input = Session::get(self::SESSION_KEY);
        }elseif ($request->session()->has('_old_input')) {
            $input = $request->session()->get('_old_input');
        }
        return view('admin.login')->with(compact(['input']));;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (!$this->attemptLogin($request)) {
            return back()->withErrors(['email' => '正しいメールアドレスを入力してください。', 'password' => '正しいパスワードを入力してください。'])->withInput($request->only('email'));
        }

        if ($request->has('remember_me')){
            Session::put(self::SESSION_KEY, ['email' => $request->email, 'password' => $request->password]);
        }else if (Session::has(self::SESSION_KEY)){
            Session::forget(self::SESSION_KEY);
        }

        $this->guard()->attempt($this->credentials($request), $request->has('remember_me'));

        return redirect()->route('admin.dashboard.purchase.index');
    }
}
