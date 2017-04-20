<div class="panel panel-warning panel-stat">
    <div class="panel-heading">
        <div class="stat">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-comment-o"></i>
                </div>
                <div class="col-xs-8">
                    <small class="stat-label">{{ trans('labels.comments_with_parent') }}</small>
                    <h1>{{ \App\Models\Comment::withParent()->count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>