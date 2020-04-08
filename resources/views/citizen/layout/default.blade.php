@extends('citizen.layout.master')

@section('header')
    @include('citizen.partials.header')
@endsection

@section('content')

    <div class="app-body">

        @if(View::exists('citizen.layout.sidebar'))
            @include('citizen.layout.sidebar')
        @endif

        <main class="main">

            <div class="container-fluid" id="app" :class="{'loading': loading}">
                <div class="modals">
                    <v-dialog/>
                </div>
                <div>
                    <notifications position="bottom right" :duration="2000" />
                </div>

                @yield('body')
            </div>
        </main>
    </div>
@endsection

@section('footer')
    @include('citizen.partials.footer')
@endsection

@section('bottom-scripts')
    @parent
@endsection
