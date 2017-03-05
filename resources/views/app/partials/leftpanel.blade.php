<div class="leftpanel">

    <div class="logopanel">
        <h1><span>[</span> bracket <span>]</span></h1>
    </div>

    <div class="leftpanelinner">
        <ul class="nav nav-pills nav-stacked nav-bracket">
            <li>
                <a href="{{ route('app.dashboard.index') }}">
                    <span class="pull-right badge badge-success">2</span>
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-parent">
                <a href="">
                    <i class="fa fa-user"></i>
                    <span>Mitglieder</span>
                </a>
                <ul class="children">
                    <li>
                        <a href="{{ route('app.member.index') }}">
                            Übersicht
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>