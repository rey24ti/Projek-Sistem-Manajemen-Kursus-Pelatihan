<?php
    /**
     * Global flash notifications.
     * Supports common keys: success, error, warning, info, status.
     */
    $flashMap = [
        'success' => 'success',
        'status' => 'success',
        'error' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
    ];

    $flashMessages = [];
    foreach ($flashMap as $key => $bootstrapType) {
        if (session()->has($key) && filled(session($key))) {
            $flashMessages[] = [
                'type' => $bootstrapType,
                'message' => session($key),
            ];
        }
    }

    if ($errors->any()) {
        $flashMessages[] = [
            'type' => 'danger',
            'message' => $errors->first(),
        ];
    }
?>

<?php if(count($flashMessages)): ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080; max-width: 420px;">
        <?php $__currentLoopData = $flashMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-<?php echo e($item['type']); ?> text-white alert-dismissible fade show mb-2" role="alert" data-flash-autohide>
                <span class="alert-text"><?php echo e($item['message']); ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/layouts/partials/flash.blade.php ENDPATH**/ ?>