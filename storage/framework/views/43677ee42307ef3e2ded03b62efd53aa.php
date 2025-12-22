

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Pendaftaran Saya</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nilai</th>
                <th class="text-secondary opacity-7">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo e($enrollment->course->title); ?></h6>
                      <p class="text-xs text-secondary mb-0"><?php echo e($enrollment->course->category->name); ?></p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-<?php echo e($enrollment->status_badge); ?>"><?php echo e(ucfirst($enrollment->status)); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <?php if($enrollment->payment_status): ?>
                    <span class="badge badge-sm bg-gradient-<?php echo e($enrollment->payment_status_badge); ?>"><?php echo e(ucfirst($enrollment->payment_status)); ?></span>
                    <?php if($enrollment->payment_status == 'pending'): ?>
                      <br><small><a href="<?php echo e(route('payments.create', $enrollment)); ?>" class="text-warning">Upload Bukti</a></small>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-secondary text-xs">-</span>
                  <?php endif; ?>
                </td>
                <td class="align-middle text-center">
                  <div class="progress-wrapper w-75 mx-auto">
                    <div class="progress-info">
                      <div class="progress-percentage">
                        <span class="text-xs font-weight-bold"><?php echo e($enrollment->progress); ?>%</span>
                      </div>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-info" style="width: <?php echo e($enrollment->progress); ?>%"></div>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <?php if($enrollment->final_score !== null): ?>
                    <span class="text-xs font-weight-bold"><?php echo e(number_format($enrollment->final_score, 2)); ?></span>
                    <?php if($enrollment->is_passed): ?>
                      <br><span class="badge badge-sm bg-gradient-success">Lulus</span>
                    <?php else: ?>
                      <br><span class="badge badge-sm bg-gradient-danger">Tidak Lulus</span>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-secondary text-xs">-</span>
                  <?php endif; ?>
                </td>
                <td class="align-middle">
                  <div class="d-flex flex-column gap-1">
                    <a href="<?php echo e(route('courses.show', $enrollment->course)); ?>" class="text-info font-weight-bold text-xs">Kursus</a>
                    <?php if($enrollment->status == 'approved'): ?>
                      <a href="<?php echo e(route('courses.student.materials', $enrollment->course)); ?>" class="text-primary font-weight-bold text-xs">Materi</a>
                      <a href="<?php echo e(route('courses.student.assignments', $enrollment->course)); ?>" class="text-info font-weight-bold text-xs">Tugas</a>
                      <?php if($enrollment->is_passed && $enrollment->certificate_path): ?>
                        <a href="<?php echo e(route('certificates.show', $enrollment)); ?>" class="text-success font-weight-bold text-xs" target="_blank">Sertifikat</a>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="6" class="text-center">Anda belum terdaftar pada kursus apapun</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          <?php echo e($enrollments->links()); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/guest/enrollments/index.blade.php ENDPATH**/ ?>