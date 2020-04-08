<?php

namespace App\Http\Middleware\Citizen;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated
 *
 * @package App\Http\Middleware\Citizen
 */
class RedirectIfAuthenticated
{
    /**
     * Guard used for citizen
     *
     * @var string
     */
    protected $guard = 'citizen';

    /**
     * RedirectIfAuthenticated constructor.
     */
    public function __construct()
    {
        $this->guard = config('citizen-auth.defaults.guard');
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
                return redirect(config('citizen-auth.login_redirect'));
            } else {
                return redirect('/' . $guard . '/login');
            }
        }

        return $next($request);
    }
}
