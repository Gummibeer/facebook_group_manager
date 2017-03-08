@extends('layouts.auth')

@section('content')
    <div class="locked">
        <i class="fa fa-lock"></i>
    </div>
    <a href="{{ route('auth.facebook.redirect') }}" class="btn btn-primary">
        <i class="fa fa-facebook"></i>
        Login
    </a>
@endsection