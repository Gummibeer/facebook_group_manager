<div class="panel panel-danger panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-user-o pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.members_without_contribution') }}</small>
                <h1>{{ \App\Models\Member::byActive()->withoutContribution()->count() }}</h1>
            </div>
        </div>
    </div>
</div>