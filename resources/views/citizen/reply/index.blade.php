@extends('citizen.layout.default')

@section('title', 'Replies')

@section('body')

    <reply-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/replies') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Replies
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Search" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)">
                                                    <i class="fa fa-search"></i>&nbsp; Search
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th is='sortable' :column="'id'"> ID </th>
                                        <th is='sortable' :column="'reply_time'"> Reply Time </th>
                                        <th is='sortable' :column="'officer_id'"> Officer </th>
                                        <th is='sortable' :column="'report_id'"> Report </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" v-if="item.report && item.report.citizen_id == {{ Auth::user()->id }}" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.reply_time | datetime }}</td>
                                        <td>@{{ item.officer.name }}</td>
                                        <td>@{{ item.report.title }}</td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info disabled" :href="item.resource_url.citizen" title="Show" role="button"><i class="fa fa-info"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/replies/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.reply.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </reply-listing>

@endsection
