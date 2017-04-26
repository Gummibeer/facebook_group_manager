<div class="panel panel-warning panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-comment-o pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.comments_with_parent') }}</small>
                <h1>{{ \App\Models\Comment::withParent()->count() }}</h1>
            </div>
        </div>
    </div>
</div>