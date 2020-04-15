@extends('officer.layout.default')

@section('title', 'Edit Reply')

@section('body')

    <div class="container-xl">
        <div class="card">

            <reply-form
                :action="'{{ $reply->resource_url['officer'] }}'"
                :data="{{ $reply->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> Edit Reply
                    </div>

                    <div class="card-body">
                        @include('officer.reply.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            Save
                        </button>
                    </div>

                </form>

        </reply-form>

        </div>

</div>

@endsection
