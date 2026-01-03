

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Peserta Kursus</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <form method="GET" action="<?php echo e(route('enrollments.index')); ?>" class="p-3">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="search" class="form-control" placeholder="Cari peserta atau kursus..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-4">
              <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
          </div>
        </form>
        <div class="row p-3">
          <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title mb-0"><?php echo e($enrollment->user->name); ?></h5>
                <p class="card-text text-sm text-secondary"><?php echo e($enrollment->user->email); ?></p>

                <p class="text-xs text-secondary mb-2">
                  <strong>Kursus:</strong> <?php echo e($enrollment->course->title); ?><br>
                  <strong>Status:</strong> <span class="badge badge-sm bg-gradient-<?php echo e($enrollment->status_badge); ?>"><?php echo e(ucfirst($enrollment->status)); ?></span>
                </p>

                <div class="progress-wrapper">
                  <div class="progress-info">
                    <div class="progress-percentage">
                      <span class="text-xs font-weight-bold"><?php echo (int)($enrollment->progress ?? 0); ?>%</span>
                    </div>
                  </div>
                  <div class="progress">
                    <div class="progress-bar bg-gradient-info" style="width: <?php echo (int)($enrollment->progress ?? 0); ?>%"></div>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <form action="<?php echo e(route('enrollments.update', $enrollment)); ?>" method="POST" class="d-flex align-items-center flex-wrap gap-2">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('PUT'); ?>
                  <select name="status" class="form-control form-control-sm" style="width: auto;" onchange="this.form.submit()">
                    <option value="pending" <?php echo e($enrollment->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="approved" <?php echo e($enrollment->status == 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="rejected" <?php echo e($enrollment->status == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                    <option value="completed" <?php echo e($enrollment->status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                  </select>
                  <input type="number" name="progress" class="form-control form-control-sm" style="width: 110px;" value="<?php echo e($enrollment->progress); ?>" min="0" max="100" placeholder="Progress %">
                </form>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="col-12">
            <p class="text-center">Tidak ada peserta</p>
          </div>
          <?php endif; ?>
        </div>
        <div class="px-3 py-2">
          <?php echo e($enrollments->links()); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/staff/enrollments/index.blade.php ENDPATH**/ ?>