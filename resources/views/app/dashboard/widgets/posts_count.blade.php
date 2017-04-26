<div class="panel panel-dark panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-commenting pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.posts') }}</small>
                <h1>{{ \App\Models\Post::count() }}</h1>
            </div>
        </div>
    </div>
</div>