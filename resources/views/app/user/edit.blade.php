@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('app.user.update', $user->getKey()) }}">
        {{ csrf_field() }}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('labels.user') }}</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <strong>{{ trans('labels.full_name') }}</strong>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ trans('labels.email') }}</strong>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ trans('labels.facebook_id') }}</strong>
                        <p>{{ $user->facebook_id }}</p>
                    </div>
                    <div class="col-md-1">
                        <label for="select_is_admin">{{ trans('labels.is_admin') }}</label>
                        <select class="form-control" id="select_is_admin" name="is_admin">
                            <option value="1" @if($user->is_admin) selected @endif>{{ trans('labels.yes') }}</option>
                            <option value="0" @if(!$user->is_admin) selected @endif>{{ trans('labels.no') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group pull-right">
                    <a href="{{ route('app.user.index') }}" class="btn btn-default">
                        {{ trans('labels.close') }}
                    </a>
                    <button type="submit" class="btn btn-warning">
                        {{ trans('labels.save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection