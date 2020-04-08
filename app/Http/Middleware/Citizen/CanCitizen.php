<?php

namespace App\Http\Middleware\Citizen;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

/**
 * Class CanCitizen
 *
 * @package App\Http\Middleware\Citizen
 */
class CanCitizen
{
    /**
     * Guard used for citizen
     *
     * @var string
     */
    protected $guard = 'citizen';

    /**
     * CanCitizen constructor.
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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard($this->guard)->check() && Auth::guard($this->guard)->user()->can('citizen')) {
            return $next($request);
        }

        if (!Auth::guard($this->guard)->check()) {
            return redirect()->guest('/citizen/login');
        } else {
            throw new UnauthorizedException('Unauthorized');
        }
    }
}
