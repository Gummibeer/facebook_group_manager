<div class="panel panel-danger panel-stat">
    <div class="panel-heading">
        <div class="stat">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-user-o"></i>
                </div>
                <div class="col-xs-8">
                    <small class="stat-label">{{ trans('labels.members_without_contribution') }}</small>
                    <h1>{{ \App\Models\Member::byActive()->withoutContribution()->count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>