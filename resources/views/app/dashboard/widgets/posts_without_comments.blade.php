<div class="panel panel-danger panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-commenting-o pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.posts_without_comments') }}</small>
                <h1>{{ \App\Models\Post::withoutComments()->count() }}</h1>
            </div>
        </div>
    </div>
</div>