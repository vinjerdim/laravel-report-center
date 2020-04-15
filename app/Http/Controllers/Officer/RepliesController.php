<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Officer\Reply\BulkDestroyReply;
use App\Http\Requests\Officer\Reply\DestroyReply;
use App\Http\Requests\Officer\Reply\IndexReply;
use App\Http\Requests\Officer\Reply\StoreReply;
use App\Http\Requests\Officer\Reply\UpdateReply;
use App\Models\Reply;
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

class RepliesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexReply $request
     * @return array|Factory|View
     */
    public function index(IndexReply $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Reply::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'reply_time', 'content', 'officer_id', 'report_id'],

            // set columns to searchIn
            ['id', 'content']
        );

        foreach ($data as $reply) {
            $reply['officer'] = $reply->officer;
            $reply['report'] = $reply->report;
        }

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('officer.reply.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('officer.reply.create');

        $reply = new Reply();
        $reply['officer'] = Auth::user();

        return view('officer.reply.create', [
            'reply' => $reply,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReply $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreReply $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Reply
        $reply = Reply::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('officer/replies'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('officer/replies');
    }

    /**
     * Display the specified resource.
     *
     * @param Reply $reply
     * @throws AuthorizationException
     * @return void
     */
    public function show(Reply $reply)
    {
        $this->authorize('officer.reply.show', $reply);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reply $reply
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Reply $reply)
    {
        $this->authorize('officer.reply.edit', $reply);

        $reply['officer'] = $reply->officer;
        $reply['report'] = $reply->report;

        return view('officer.reply.edit', [
            'reply' => $reply,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReply $request
     * @param Reply $reply
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateReply $request, Reply $reply)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Reply
        $reply->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('officer/replies'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('officer/replies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyReply $request
     * @param Reply $reply
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyReply $request, Reply $reply)
    {
        $reply->delete();

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
     * @param BulkDestroyReply $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyReply $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('replies')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response([
            'message' => trans('brackets/admin-ui::admin.operation.succeeded')
        ]);
    }
}
