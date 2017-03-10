@extends('layouts.error')

@section('content')
    <h1>
        <i class="fa fa-bug text-danger"></i>
        500
    </h1>
    <h2>{{ \Symfony\Component\HttpFoundation\Response::$statusTexts[500] }}</h2>
    <a href="{{ route('app.dashboard.index') }}" class="btn btn-block btn-primary">
        {{ trans('labels.dashboard') }}
    </a>
@endsection