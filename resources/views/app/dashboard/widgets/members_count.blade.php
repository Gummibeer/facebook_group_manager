<div class="panel panel-dark panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-users pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.members') }}</small>
                <h1>{{ \App\Models\Member::byActive()->count() }}</h1>
            </div>
        </div>
    </div>
</div>