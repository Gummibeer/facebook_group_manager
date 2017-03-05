@extends('master')

@section('layout')
    <div id="preloader">
        <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
    </div>
    <section>
        @include('app.partials.leftpanel')
        <div class="mainpanel">
            @include('app.partials.headerbar')
            <div class="contentpanel">
                @yield('content')
            </div>
        </div>
    </section>
@endsection