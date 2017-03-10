@extends('layouts.error')

@section('content')
    <h1>
        <i class="fa fa-user-secret text-danger"></i>
        403
    </h1>
    <h2>{{ \Symfony\Component\HttpFoundation\Response::$statusTexts[403] }}</h2>
    <a href="{{ route('app.dashboard.index') }}" class="btn btn-block btn-primary">
        {{ trans('labels.dashboard') }}
    </a>
@endsection