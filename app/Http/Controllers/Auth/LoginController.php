<?php

namespace Sicere\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Sicere\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username(){
        return 'user_codigo';
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['user_seleccionable' => 1]);
    }

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function logout(){
        if(Auth::check()){
        \Auth::logout();
        session()->flush();
        }
        return redirect('/');
    }
}
