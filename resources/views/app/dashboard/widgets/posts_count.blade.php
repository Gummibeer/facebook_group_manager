<div class="panel panel-dark panel-stat">
    <div class="panel-heading">
        <div class="stat">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-commenting"></i>
                </div>
                <div class="col-xs-8">
                    <small class="stat-label">{{ trans('labels.posts') }}</small>
                    <h1>{{ \App\Models\Post::count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>