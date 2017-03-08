<?php $__env->startSection('layout'); ?>
    <div id="preloader">
        <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
    </div>
    <section>
        <?php echo $__env->make('app.partials.leftpanel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="mainpanel">
            <?php echo $__env->make('app.partials.headerbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="contentpanel">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>