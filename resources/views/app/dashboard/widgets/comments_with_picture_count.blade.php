<div class="panel panel-success panel-stat">
    <div class="panel-heading">
        <div class="stat clearfix">
            <i class="fa fa-picture-o pull-left"></i>
            <div class="pull-left">
                <small class="stat-label">{{ trans('labels.comments_with_picture') }}</small>
                <h1>{{ \App\Models\Comment::withPicture()->count() }}</h1>
            </div>
        </div>
    </div>
</div>