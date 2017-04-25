@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">{{ trans('labels.autoposts') }}</h4>
        </div>
        <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>{{ trans('labels.message') }}</th>
                <th>{{ trans('labels.type') }}</th>
                <th>{{ trans('labels.next_run') }}</th>
                <th>{{ trans('labels.cron_expression') }}</th>
                <th>{{ trans('labels.timezone') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($autoposts as $autopost)
            <tr>
                <td>{!! nl2br($autopost->getMessage()) !!}</td>
                <td>
                    @if($autopost->isPhoto())
                        <i class="icon fa fa-picture-o"></i>
                    @else
                        <i class="icon fa fa-file-text-o"></i>
                    @endif
                </td>
                <td>{{ $autopost->getNextDate()->format('Y-m-d H:i T') }}</td>
                <td>{{ $autopost->getExpression() }}</td>
                <td>{{ $autopost->getTimezone() }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection