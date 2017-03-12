@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('app.member.update', $member->getKey()) }}">
        {{ csrf_field() }}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('labels.member') }}</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <strong>{{ trans('labels.full_name') }}</strong>
                        <p>{{ $member->full_name }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ trans('labels.facebook_id') }}</strong>
                        <p>{{ $member->id }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ trans('labels.is_admin') }}</strong>
                        <p>{{ $member->is_administrator }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ trans('labels.gender_by_name') }}</strong>
                        <p>{{ trans('labels.'.app(\App\Libs\Gender::class)->getLabel($member->gender_by_name)) }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ trans('labels.gender_by_picture') }}</strong>
                        <p>{{ trans('labels.'.app(\App\Libs\Gender::class)->getLabel($member->gender_by_picture)) }}</p>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ trans('labels.age_by_picture') }}</strong>
                        <p>{{ $member->age_by_picture }}</p>
                    </div>
                    <div class="col-md-1">
                        <label for="select_gender">{{ trans('labels.gender') }}</label>
                        <select class="form-control" id="select_gender" name="gender">
                            @foreach(app(\App\Libs\Gender::class)->getLabels() as $id => $name)
                                <option value="{{ $id }}" @if($member->getAttributes()['gender'] == $id) selected @endif>{{ trans('labels.'.$name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for="select_age">{{ trans('labels.age') }}</label>
                        <input type="number" class="form-control" id="select_age" name="age" value="{{ $member->getAttributes()['age'] }}" />
                    </div>
                    <div class="col-md-1">
                        <label for="select_is_approved">{{ trans('labels.is_approved') }}</label>
                        <select class="form-control" id="select_is_approved" name="is_approved">
                            <option value="1" @if($member->is_approved) selected @endif>{{ trans('labels.yes') }}</option>
                            <option value="0" @if(!$member->is_approved) selected @endif>{{ trans('labels.no') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group pull-right">
                    <a href="{{ route('app.member.index') }}" class="btn btn-default">
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