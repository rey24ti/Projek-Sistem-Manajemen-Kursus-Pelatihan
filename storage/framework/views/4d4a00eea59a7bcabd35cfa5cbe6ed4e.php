

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Laporan</h6>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Total Kursus</h6>
                <h3 class="mb-0"><?php echo e($stats['total_courses']); ?></h3>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Total Pendaftaran</h6>
                <h3 class="mb-0"><?php echo e($stats['total_enrollments']); ?></h3>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Kursus Aktif</h6>
                <h3 class="mb-0"><?php echo e($stats['active_courses']); ?></h3>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Kursus Selesai</h6>
                <h3 class="mb-0"><?php echo e($stats['completed_courses']); ?></h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h6>Pendaftaran Terbaru</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th>Peserta</th>
                        <th>Kursus</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $recentEnrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td><?php echo e($enrollment->user->name); ?></td>
                        <td><?php echo e($enrollment->course->title); ?></td>
                        <td><span class="badge bg-gradient-<?php echo e($enrollment->status_badge); ?>"><?php echo e(ucfirst($enrollment->status)); ?></span></td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h6>Statistik Kursus</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th>Kursus</th>
                        <th>Peserta</th>
                        <th>Selesai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td><?php echo e($course->title); ?></td>
                        <td><?php echo e($course->total_enrollments); ?></td>
                        <td><?php echo e($course->completed_enrollments); ?></td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>