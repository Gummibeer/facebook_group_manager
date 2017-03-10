@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-dark panel-stat">
                <div class="panel-heading">
                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">{{ trans('labels.members') }}</small>
                                <h1>{{ \App\Models\Member::byActive()->count() }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection