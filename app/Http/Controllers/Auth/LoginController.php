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

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param type $user
     * @return typeNOT used in StudentFolder.info, but used in TheDirectorsRooms.com and
     * AuditionForms.com.
     * Kept here as a tested placeholder
     */
    public function authenticated(\Illuminate\Http\Request $request, $user)
    {
        //if (!$user->verified) {
        //  auth()->logout();

        //  return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
       // }
       // return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * Students validate on an the user name NOT (default) email address
     *
     * @return string
     */
   // public function username()
    //{
        /**
         * FJR 13-Jan-2020
         * override default */
        //return 'email';

    //    return 'username';
    //}
}
