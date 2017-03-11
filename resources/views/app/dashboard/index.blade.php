@extends('layouts.app')

@section('content')
    <div class="row grid">
        <div class="col-xs-12 col-md-3 grid-item">
            @include('app.dashboard.widgets.members_count')
        </div>
        <div class="col-xs-12 col-md-3 grid-item">
            @include('app.dashboard.widgets.members_without_avatar')
        </div>
        <div class="col-xs-12 col-md-3 grid-item">
            @include('app.dashboard.widgets.members_approved')
        </div>
        <div class="col-xs-12 col-md-3 grid-item">
            @include('app.dashboard.widgets.members_by_gender')
        </div>
        <div class="col-xs-12 col-md-3 grid-item">
            @include('app.dashboard.widgets.members_by_approved')
        </div>
    </div>
@endsection