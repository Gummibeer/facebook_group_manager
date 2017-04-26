<div class="panel panel-info panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-comment pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.comments_without_parent') }}</small>
                <h1>{{ \App\Models\Comment::withoutParent()->count() }}</h1>
            </div>
        </div>
    </div>
</div>