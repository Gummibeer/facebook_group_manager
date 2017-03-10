@extends('layouts.auth')

@section('content')
    <div class="locked">
        <i class="fa fa-lock fa-2x"></i>
    </div>
    <a href="{{ route('auth.facebook.redirect') }}" class="btn btn-primary">
        <i class="fa fa-facebook"></i>
        {{ trans('labels.login') }}
    </a>
@endsection