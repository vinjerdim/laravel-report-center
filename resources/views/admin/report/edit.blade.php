@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Edit Report')

@section('body')

    <div class="container-xl">
        <div class="card">

            <report-form
                :action="'{{ $report->resource_url['admin'] }}'"
                :data="{{ $report->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> Edit Report
                    </div>

                    <div class="card-body">
                        @include('admin.report.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </report-form>

        </div>

</div>

@endsection
