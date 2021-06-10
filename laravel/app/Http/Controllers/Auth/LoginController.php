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

//    protected function sendFailedLoginResponse(Request $request)
//    {
//        $errors = [$this->username() => trans('auth.failed')];
//
//        // Load user from database
//        $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();
//
//        // Check if user was successfully loaded, that the password matches
//        // and active is not 1. If so, override the default error message.
//        if ($user && \Hash::check($request->password, $user->password) && empty($user->email_verified_at)) {
//            $errors = [$this->username() => 'Your account is not active.'];
//        }
//
//        if ($request->expectsJson()) {
//            return response()->json($errors, 422);
//        }
//
//        return redirect()->back()
//            ->withInput($request->only($this->username(), 'remember'))
//            ->withErrors($errors);
//    }
}
