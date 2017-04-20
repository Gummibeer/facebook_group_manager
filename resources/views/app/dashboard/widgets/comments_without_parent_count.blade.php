<div class="panel panel-info panel-stat">
    <div class="panel-heading">
        <div class="stat">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-comment"></i>
                </div>
                <div class="col-xs-8">
                    <small class="stat-label">{{ trans('labels.comments_without_parent') }}</small>
                    <h1>{{ \App\Models\Comment::withoutParent()->count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>