<?php

namespace App\Http\Controllers\Citizen\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/citizen';

    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
    protected $redirectToAfterLogout = '/citizen/login';

    /**
     * Guard used for citizen
     *
     * @var string
     */
    protected $guard = 'citizen';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard = config('citizen-auth.defaults.guard');
        $this->redirectTo = config('citizen-auth.login_redirect');
        $this->redirectToAfterLogout = config('citizen-auth.logout_redirect');
        $this->middleware([
            'guest.citizen:' . 'admin',
            'guest.citizen:' . 'officer',
            'guest.citizen:' . 'citizen',
        ])->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return Response
     */
    public function showLoginForm()
    {
        return view('citizen.auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect($this->redirectToAfterLogout);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request): array
    {
        $conditions = [];
        if (config('citizen-auth.check_forbidden')) {
            $conditions['forbidden'] = false;
        }
        if (config('citizen-auth.activation_enabled')) {
            $conditions['activated'] = true;
        }
        return array_merge($request->only($this->username(), 'password'), $conditions);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectAfterLogoutPath(): string
    {
        if (method_exists($this, 'redirectToAfterLogout')) {
            return $this->redirectToAfterLogout();
        }

        return property_exists($this, 'redirectToAfterLogout') ? $this->redirectToAfterLogout : '/';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard($this->guard);
    }

    public function username()
    {
        return 'username';
    }
}
