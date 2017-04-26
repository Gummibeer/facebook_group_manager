<div class="leftpanel">

    <div class="logopanel">
        <h1>
            <span>FB</span>
            {{ config('app.name') }}
        </h1>
    </div>

    <div class="leftpanelinner">
        <ul class="nav nav-pills nav-stacked nav-bracket">
            <li>
                <a href="{{ route('app.dashboard.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('labels.dashboard') }}</span>
                </a>
            </li>
            @can('manage-member')
            <li>
                <a href="{{ route('app.member.index') }}">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('labels.members') }}</span>
                </a>
            </li>
            @endcan
            <li>
                <a href="{{ route('app.post.index') }}">
                    <i class="fa fa-commenting"></i>
                    <span>{{ trans('labels.posts') }}</span>
                </a>
            </li>
        </ul>
        @can('administration')
        <h5 class="sidebartitle">{{ trans('labels.administration') }}</h5>
        <ul class="nav nav-pills nav-stacked nav-bracket">
            @can('manage-user')
            <li>
                <a href="{{ route('app.user.index') }}">
                    <i class="fa fa-user-secret"></i>
                    <span>{{ trans('labels.users') }}</span>
                </a>
            </li>
            @endcan
            @can('view-autopost')
            <li>
                <a href="{{ route('app.autopost.index') }}">
                    <i class="fa fa-magic"></i>
                    <span>{{ trans('labels.autoposts') }}</span>
                </a>
            </li>
            @endcan
        </ul>
        @endcan
    </div>
</div>