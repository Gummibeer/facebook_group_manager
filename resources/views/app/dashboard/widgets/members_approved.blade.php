<div class="panel panel-success panel-stat">
    <div class="panel-heading">
        <div class="stat">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-check"></i>
                </div>
                <div class="col-xs-8">
                    <small class="stat-label">{{ trans('labels.members_approved') }}</small>
                    <h1>{{ \App\Models\Member::byActive()->byApproved()->count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>