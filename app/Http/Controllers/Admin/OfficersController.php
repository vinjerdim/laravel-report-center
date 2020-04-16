<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Officer\BulkDestroyOfficer;
use App\Http\Requests\Admin\Officer\DestroyOfficer;
use App\Http\Requests\Admin\Officer\IndexOfficer;
use App\Http\Requests\Admin\Officer\StoreOfficer;
use App\Http\Requests\Admin\Officer\UpdateOfficer;
use App\Models\Officer;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class OfficersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexOfficer $request
     * @return array|Factory|View
     */
    public function index(IndexOfficer $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Officer::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'username', 'phone'],

            // set columns to searchIn
            ['id', 'name', 'username', 'phone']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.officer.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.officer.create');

        return view('admin.officer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOfficer $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreOfficer $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['password'] = Hash::make($sanitized['password']);

        // Store the Officer
        $officer = Officer::create($sanitized);
        $officer->assignRole('Officer');

        if ($request->ajax()) {
            return ['redirect' => url('admin/officers'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/officers');
    }

    /**
     * Display the specified resource.
     *
     * @param Officer $officer
     * @throws AuthorizationException
     * @return void
     */
    public function show(Officer $officer)
    {
        $this->authorize('admin.officer.show', $officer);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Officer $officer
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Officer $officer)
    {
        $this->authorize('admin.officer.edit', $officer);


        return view('admin.officer.edit', [
            'officer' => $officer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOfficer $request
     * @param Officer $officer
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateOfficer $request, Officer $officer)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Officer
        $officer->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/officers'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/officers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyOfficer $request
     * @param Officer $officer
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyOfficer $request, Officer $officer)
    {
        $officer->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyOfficer $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyOfficer $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('officers')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
