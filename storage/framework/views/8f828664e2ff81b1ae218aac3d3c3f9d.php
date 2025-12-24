


<?php $__env->startSection('guest'); ?>
    <?php if(\Request::is('login/forgot-password')): ?> 
        <?php echo $__env->make('layouts.navbars.guest.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?> 
    <?php else: ?>
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('layouts.navbars.guest.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
        <?php echo $__env->yieldContent('content'); ?>        
        <?php echo $__env->make('layouts.footers.guest.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('auth'); ?>
    <?php if(\Request::is('login/forgot-password')): ?> 
        <?php echo $__env->make('layouts.navbars.guest.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?> 
    <?php else: ?>
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    <?php echo $__env->make('layouts.navbars.guest.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
        <?php echo $__env->yieldContent('content'); ?>        
        <?php echo $__env->make('layouts.footers.guest.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/layouts/user_type/guest.blade.php ENDPATH**/ ?>