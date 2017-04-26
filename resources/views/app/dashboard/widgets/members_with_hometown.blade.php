<div class="panel panel-success panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-home pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.members_with_hometown') }}</small>
                <h1>{{ \App\Models\Member::byActive()->withHometown()->count() }}</h1>
            </div>
        </div>
    </div>
</div>