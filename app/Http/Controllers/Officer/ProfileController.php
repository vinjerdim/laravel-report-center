<?php

namespace App\Http\Controllers\Officer;

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
    public $officerUser;

    /**
     * Guard used for officer
     *
     * @var string
     */
    protected $guard = 'officer';

    public function __construct()
    {
        // TODO add authorization
        $this->guard = config('officer-auth.defaults.guard');
    }

    /**
     * Get logged user before each method
     *
     * @param Request $request
     */
    protected function setUser($request)
    {
        if (empty($request->user($this->guard))) {
            abort(404, 'User not found');
        }

        $this->officerUser = $request->user($this->guard);
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

        return view('officer.profile.edit-profile', [
            'officerUser' => $this->officerUser,
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
        ]);

        // Sanitize input
        $sanitized = $request->only([
            'name',
            'phone',
        ]);

        // Update changed values Officer
        $this->officerUser->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('officer/profile'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('officer/profile');
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

        return view('officer.profile.edit-password', [
            'officerUser' => $this->officerUser,
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

        // Update changed values Officer
        $this->officerUser->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('officer/password'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('officer/password');
    }
}
