<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function authenticated()
    {
        return redirect('/students_tests');
    }

    protected function credentials()
    {
        $username = $this->username();
        $credentials = request()->only($username, 'password');
        if (isset($credentials[$username])) {
            $credentials[$username] = strtolower($credentials[$username]);
        }
        if (isset($credentials['password'])) {
            $credentials[$username] = strtolower($credentials['password']);
        }
        return $credentials;
    }

}