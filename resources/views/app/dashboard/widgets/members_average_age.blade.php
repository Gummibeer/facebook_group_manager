<div class="panel panel-info panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-clock-o pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.members_average_age') }}</small>
                <h1>{{ round(\App\Models\Member::byActive()->withAge()->avg('age')) }}</h1>
            </div>
        </div>
    </div>
</div>