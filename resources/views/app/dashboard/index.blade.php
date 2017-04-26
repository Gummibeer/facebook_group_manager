@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.members_count')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.members_without_avatar')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.members_without_contribution')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.members_approved')
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.posts_count')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.posts_without_comments')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.posts_with_picture_count')
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.comments_count')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.comments_without_parent_count')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.comments_with_parent_count')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.comments_with_picture_count')
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.members_by_gender')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.members_by_approved')
        </div>
        <div class="col-xs-12 col-md-3">
            @include('app.dashboard.widgets.command_state')
        </div>
    </div>
    @include('app.dashboard.widgets.activity_calendar')
    @include('app.dashboard.widgets.members_hometowns')
@endsection