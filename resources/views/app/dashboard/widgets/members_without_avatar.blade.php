<div class="panel panel-danger panel-stat">
    <div class="panel-heading">
        <div class="stat">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-image"></i>
                </div>
                <div class="col-xs-8">
                    <small class="stat-label">{{ trans('labels.members_without_avatar') }}</small>
                    <h1>{{ \App\Models\Member::byIsSilhouette()->count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>