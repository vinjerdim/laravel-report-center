<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Citizen\BulkDestroyCitizen;
use App\Http\Requests\Admin\Citizen\DestroyCitizen;
use App\Http\Requests\Admin\Citizen\IndexCitizen;
use App\Http\Requests\Admin\Citizen\StoreCitizen;
use App\Http\Requests\Admin\Citizen\UpdateCitizen;
use App\Models\Citizen;
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
use Illuminate\View\View;

class CitizensController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCitizen $request
     * @return array|Factory|View
     */
    public function index(IndexCitizen $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Citizen::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'username', 'email', 'phone'],

            // set columns to searchIn
            ['id', 'name', 'username', 'email', 'phone']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.citizen.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.citizen.create');

        return view('admin.citizen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCitizen $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCitizen $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Citizen
        $citizen = Citizen::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/citizens'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/citizens');
    }

    /**
     * Display the specified resource.
     *
     * @param Citizen $citizen
     * @throws AuthorizationException
     * @return void
     */
    public function show(Citizen $citizen)
    {
        $this->authorize('admin.citizen.show', $citizen);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Citizen $citizen
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Citizen $citizen)
    {
        $this->authorize('admin.citizen.edit', $citizen);


        return view('admin.citizen.edit', [
            'citizen' => $citizen,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCitizen $request
     * @param Citizen $citizen
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCitizen $request, Citizen $citizen)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Citizen
        $citizen->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/citizens'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/citizens');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCitizen $request
     * @param Citizen $citizen
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCitizen $request, Citizen $citizen)
    {
        $citizen->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCitizen $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCitizen $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('citizens')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
