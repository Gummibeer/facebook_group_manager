<div class="panel panel-danger panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-image pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.members_without_avatar') }}</small>
                <h1>{{ \App\Models\Member::byActive()->byIsSilhouette()->count() }}</h1>
            </div>
        </div>
    </div>
</div>