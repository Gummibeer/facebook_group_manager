@extends('master')

@section('body-class', 'notfound')

@section('layout')
    <section>
        <div class="notfoundpanel">
            @yield('content')
        </div>
    </section>
@endsection