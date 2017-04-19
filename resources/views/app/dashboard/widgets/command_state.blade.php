<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">{{ trans('labels.commands_state') }}</h4>
    </div>
    <div class="list-group">
        @foreach($commands as $command)
        <div class="list-group-item">
            <h4 class="list-group-item-heading">
                @if($command->isRunning())
                    <i class="fa fa-play-circle text-success"></i>
                @else
                    <i class="fa fa-stop-circle text-danger"></i>
                @endif
                {{ $command->getName() }}
                <span class="badge pull-right">
                    {{ $command->running() }}
                </span>
            </h4>
            <div class="list-group-item-text">
                {{ $command->read() }}
            </div>
        </div>
        @endforeach
    </div>
</div>