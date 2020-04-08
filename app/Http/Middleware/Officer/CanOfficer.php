<?php

namespace App\Http\Middleware\Officer;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

/**
 * Class CanOfficer
 *
 * @package App\Http\Middleware\Officer
 */
class CanOfficer
{
    /**
     * Guard used for officer user
     *
     * @var string
     */
    protected $guard = 'officer';

    /**
     * CanOfficer constructor.
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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard($this->guard)->check() && Auth::guard($this->guard)->user()->can('officer')) {
            return $next($request);
        }

        if (!Auth::guard($this->guard)->check()) {
            return redirect()->guest('/officer/login');
        } else {
            throw new UnauthorizedException('Unauthorized');
        }
    }
}
