<?php

namespace App\Http\Middleware\Officer;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated
 *
 * @package Brackets\AdminAuth\Http\Middleware
 */
class RedirectIfAuthenticated
{
    /**
     * Guard used for officer user
     *
     * @var string
     */
    protected $guard = 'officer';

    /**
     * RedirectIfAuthenticated constructor.
     */
    public function __construct()
    {
        $this->guard = config('officer-auth.defaults.guard');
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard === $this->guard) {
                return redirect(config('officer-auth.login_redirect'));
            } else {
                return redirect('/officer/login');
            }
        }

        return $next($request);
    }
}
