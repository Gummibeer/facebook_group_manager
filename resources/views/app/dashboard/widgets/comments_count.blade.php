<div class="panel panel-dark panel-stat">
    <div class="panel-heading">
        <div class="stat">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-comments-o"></i>
                </div>
                <div class="col-xs-8">
                    <small class="stat-label">{{ trans('labels.comments') }}</small>
                    <h1>{{ \App\Models\Comment::count() }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>