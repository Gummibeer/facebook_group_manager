@extends('master')

@section('body-class', 'notfound')

@section('layout')
    <section>
        <div class="lockedpanel">
            @yield('content')
        </div>
    </section>
@endsection