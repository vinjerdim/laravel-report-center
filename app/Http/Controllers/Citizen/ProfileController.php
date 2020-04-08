<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public $citizen;

    /**
     * Guard used for citizen
     *
     * @var string
     */
    protected $guard = 'citizen';

    public function __construct()
    {
        // TODO add authorization
        $this->guard = config('citizen-auth.defaults.guard');
    }

    /**
     * Get logged user before each method
     *
     * @param Request $request
     */
    protected function setUser($request)
    {
        if (empty($request->user($this->guard))) {
            abort(404, 'Citizen not found');
        }

        $this->citizen = $request->user($this->guard);
    }

    /**
     * Show the form for editing logged user profile.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function editProfile(Request $request)
    {
        $this->setUser($request);

        return view('citizen.profile.edit-profile', [
            'citizen' => $this->citizen,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @throws ValidationException
     * @return array|RedirectResponse|Redirector
     */
    public function updateProfile(Request $request)
    {
        $this->setUser($request);

        // Validate the request
        $this->validate($request, [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('citizens', 'email')->ignore($this->citizen->getKey(), $this->citizen->getKeyName()), 'string'],
        ]);

        // Sanitize input
        $sanitized = $request->only([
            'name',
            'phone',
            'email',
        ]);

        // Update changed values Citizen
        $this->citizen->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('citizen/profile'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('citizen/profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function editPassword(Request $request)
    {
        $this->setUser($request);

        return view('citizen.profile.edit-password', [
            'citizen' => $this->citizen,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @throws ValidationException
     * @return array|RedirectResponse|Redirector
     */
    public function updatePassword(Request $request)
    {
        $this->setUser($request);

        // Validate the request
        $this->validate($request, [
            'password' => ['sometimes', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],

        ]);

        // Sanitize input
        $sanitized = $request->only([
            'password',
        ]);

        //Modify input, set hashed password
        $sanitized['password'] = Hash::make($sanitized['password']);

        // Update changed values Citizen
        $this->citizen->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('citizen/password'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('citizen/password');
    }
}
