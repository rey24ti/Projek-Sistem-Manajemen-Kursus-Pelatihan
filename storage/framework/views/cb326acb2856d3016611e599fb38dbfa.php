

<?php $__env->startSection('auth'); ?>

    <?php echo $__env->make('layouts.navbars.auth.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <?php echo $__env->make('layouts.navbars.auth.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="container-fluid py-4">
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->make('layouts.footers.auth.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/layouts/user_type/auth.blade.php ENDPATH**/ ?>