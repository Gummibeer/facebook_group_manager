<div class="panel panel-danger panel-stat">
    <div class="panel-heading">
        <div class="stat">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-commenting-o"></i>
                </div>
                <div class="col-xs-8">
                    <small class="stat-label">{{ trans('labels.posts_without_comments') }}</small>
                    <h1>{{ \App\Models\Post::withoutComments()->count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>