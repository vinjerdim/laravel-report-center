<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Citizen\Reply\IndexReply;
use App\Models\Reply;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
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
            ['id', 'reply_time', 'officer_id', 'report_id'],

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

        return view('citizen.reply.index', ['data' => $data]);
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
        $this->authorize('citizen.reply.show', $reply);

        // TODO your code goes here
    }
}
