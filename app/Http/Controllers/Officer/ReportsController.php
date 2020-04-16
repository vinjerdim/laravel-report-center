<?php

namespace App\Http\Controllers\Officer;

use App\Models\Citizen;
use App\Http\Controllers\Controller;
use App\Http\Requests\Officer\Report\IndexReport;
use App\Http\Requests\Officer\Report\UpdateReport;
use App\Models\Report;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
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

        foreach ($data as $report) {
            $report['citizen'] = $report->citizen;
        }

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('officer.report.index', ['data' => $data]);
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
        $this->authorize('officer.report.show', $report);

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
        $this->authorize('officer.report.edit', $report);

        if ($report->status == 'verified') {
            return redirect('officer/reports');
        }

        $report['citizen'] = $report->citizen;

        return view('officer.report.edit', [
            'report' => $report
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
                'redirect' => url('officer/reports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('officer/reports');
    }
}
