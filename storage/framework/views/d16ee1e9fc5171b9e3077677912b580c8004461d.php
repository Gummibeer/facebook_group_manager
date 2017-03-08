<div class="headerbar">
    <a class="menutoggle"><i class="fa fa-bars"></i></a>
    <div class="header-right">
        <ul class="headermenu">
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo e(\Auth::user()->avatar); ?>" alt="" />
                        <?php echo e(\Auth::user()->name); ?>

                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                        <li>
                            <a href="<?php echo e(route('auth.logout')); ?>">
                                <i class="fa fa-sign-out"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>