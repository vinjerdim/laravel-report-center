<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Citizen\Report\BulkDestroyReport;
use App\Http\Requests\Citizen\Report\DestroyReport;
use App\Http\Requests\Citizen\Report\IndexReport;
use App\Http\Requests\Citizen\Report\StoreReport;
use App\Http\Requests\Citizen\Report\UpdateReport;
use App\Models\Report;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexReport $request
     * @return array|Factory|View
     */
    public function index(IndexReport $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Report::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'report_time', 'title', 'picture_url', 'status', 'citizen_id'],

            // set columns to searchIn
            ['id', 'title', 'content', 'picture_url', 'status']
        );

        foreach($data as $report) {
            $report['citizen'] = $report->citizen;
            $report['reply'] = $report->reply;
        }


        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('citizen.report.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('citizen.report.create');

        return view('citizen.report.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReport $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreReport $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Report
        $report = Report::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('citizen/reports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('citizen/reports');
    }

    /**
     * Display the specified resource.
     *
     * @param Report $report
     * @throws AuthorizationException
     * @return void
     */
    public function show(Report $report)
    {
        $this->authorize('citizen.report.show', $report);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Report $report
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Report $report)
    {
        $this->authorize('citizen.report.edit', $report);

        $report['citizen'] = $report->citizen;

        return view('citizen.report.edit', [
            'report' => $report,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReport $request
     * @param Report $report
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateReport $request, Report $report)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Report
        $report->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('citizen/reports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('citizen/reports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyReport $request
     * @param Report $report
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyReport $request, Report $report)
    {
        if ($report->citizen_id != Auth::user()->id) {
            return redirect('citizen');
        }

        $report->delete();

        if ($request->ajax()) {
            return response([
                'message' => trans('brackets/admin-ui::admin.operation.succeeded')
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyReport $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyReport $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('reports')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                    // TODO your code goes here
                });
        });

        return response([
            'message' => trans('brackets/admin-ui::admin.operation.succeeded')]
        );
    }
}
