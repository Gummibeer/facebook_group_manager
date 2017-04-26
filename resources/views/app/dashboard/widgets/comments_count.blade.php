<div class="panel panel-dark panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-comments-o pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.comments') }}</small>
                <h1>{{ \App\Models\Comment::count() }}</h1>
            </div>
        </div>
    </div>
</div>