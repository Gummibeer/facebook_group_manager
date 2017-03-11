<div class="leftpanel">

    <div class="logopanel">
        <h1><span>[</span> bracket <span>]</span></h1>
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
            <li class="nav-parent">
                <a href="">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('labels.members') }}</span>
                </a>
                <ul class="children">
                    <li>
                        <a href="{{ route('app.member.index') }}">
                            {{ trans('labels.index') }}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
        </ul>
        @can('manage-user')
        <h5 class="sidebartitle">{{ trans('labels.administration') }}</h5>
        <ul class="nav nav-pills nav-stacked nav-bracket">
            <li class="nav-parent">
                <a href="">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('labels.users') }}</span>
                </a>
                <ul class="children">
                    <li>
                        <a href="{{ route('app.user.index') }}">
                            {{ trans('labels.index') }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        @endcan
    </div>
</div>