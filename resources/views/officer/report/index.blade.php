@extends('officer.layout.default')

@section('title', 'Reports')

@section('body')

    <report-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('officer/reports') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Reports
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Search report" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; Search</button>
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
                                        <th is='sortable' :column="'id'">ID</th>
                                        <th is='sortable' :column="'report_time'">Time</th>
                                        <th is='sortable' :column="'title'"> Title </th>
                                        <th is='sortable' :column="'status'"> Status </th>
                                        <th is='sortable' :column="'citizen'"> Citizen </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.report_time | datetime }}</td>
                                        <td>@{{ item.title }}</td>
                                        <td>
                                            <span :class="{'badge badge-warning': item.status == 'unverified', 'badge badge-success': item.status == 'verified', 'badge badge-secondary': item.status == 'in review'}">
                                                @{{ item.status }}
                                            </span>
                                        </td>
                                        <td>@{{ item.citizen.name }}</td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :class="{'disabled' : item.status == 'verified'}" :href="item.resource_url.officer + '/edit'" title="Edit" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-success" :class="{'disabled' : item.status != 'verified'}" :href="'replies/create/' + item.id" title="Reply" role="button"><i class="fa fa-reply"></i></a>
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
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </report-listing>

@endsection
