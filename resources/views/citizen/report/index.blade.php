@extends('citizen.layout.default')

@section('title', 'Reports')

@section('body')

    <report-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('citizen/reports') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> My Reports
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('citizen/reports/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.report.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Search" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
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
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'"> ID </th>
                                        <th is='sortable' :column="'report_time'"> Report Time </th>
                                        <th is='sortable' :column="'title'"> Title </th>
                                        <th is='sortable' :column="'status'"> Status </th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="8">
                                            <span class="align-middle font-weight-light text-dark">
                                                Selected item(s) @{{ clickedBulkItemsCount }}.
                                                <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/citizen/reports')" v-if="(clickedBulkItemsCount < pagination.state.total)">
                                                    <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i>
                                                    Check all items @{{ pagination.state.total }}</a>
                                                <span class="text-primary">|</span>
                                                <a href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">
                                                    Uncheck all items
                                                </a>
                                            </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/citizen/reports/bulk-destroy')"> Delete </button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" v-if="item.citizen_id == {{ Auth::user()->id }}" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.report_time | datetime }}</td>
                                        <td>@{{ item.title }}</td>
                                        <td>
                                            <span :class="{'badge badge-warning': item.status == 'unverified', 'badge badge-success': item.status == 'verified', 'badge badge-secondary': item.status == 'in review'}">
                                                @{{ item.status }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :class="{'disabled' : item.status != 'unverified'}" :href="item.resource_url.citizen + '/edit'" title="Edit" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url.citizen)">
                                                    <button type="submit" class="btn btn-sm btn-danger" :class="{'disabled' : item.status != 'unverified'}" title="Delete"><i class="fa fa-trash-o"></i></button>
                                                </form>
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
                                <a class="btn btn-primary btn-spinner" href="{{ url('citizen/reports/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.report.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </report-listing>

@endsection
