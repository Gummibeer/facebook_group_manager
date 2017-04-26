<div class="headerbar">
    <a class="menutoggle"><i class="fa fa-bars"></i></a>
    <div class="header-right">
        <ul class="headermenu">
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ \Auth::user()->avatar }}" alt="" />
                        {{ \Auth::user()->name }}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                        @can('manage-member', \Auth::user()->member)
                        <li>
                            <a href="{{ route('app.profile.edit') }}">
                                <i class="fa fa-user"></i>
                                {{ trans('labels.profile') }}
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('auth.logout') }}">
                                <i class="fa fa-sign-out"></i>
                                {{ trans('labels.logout') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>