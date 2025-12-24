

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Detail Pengguna</h6>
          <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Informasi Pribadi</h6>
            <div class="mt-3">
              <p class="text-sm mb-2"><strong>Nama:</strong> <?php echo e($user->name); ?></p>
              <p class="text-sm mb-2"><strong>Email:</strong> <?php echo e($user->email); ?></p>
              <p class="text-sm mb-2"><strong>Role:</strong> 
                <?php if($user->role == 'staff'): ?>
                  <span class="badge bg-gradient-info">Instruktur</span>
                <?php elseif($user->role == 'guest'): ?>
                  <span class="badge bg-gradient-success">Peserta</span>
                <?php else: ?>
                  <span class="badge bg-gradient-primary">Admin</span>
                <?php endif; ?>
              </p>
              <p class="text-sm mb-2"><strong>Telepon:</strong> <?php echo e($user->phone ?? '-'); ?></p>
              <p class="text-sm mb-2"><strong>Lokasi:</strong> <?php echo e($user->location ?? '-'); ?></p>
              <?php if($user->about_me): ?>
              <p class="text-sm mb-2"><strong>Tentang:</strong> <?php echo e($user->about_me); ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <?php if($user->role == 'staff'): ?>
        <div class="row mb-4">
          <div class="col-12">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Kursus yang Diajarkan</h6>
            <div class="table-responsive mt-3">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul Kursus</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__empty_1 = true; $__currentLoopData = $user->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <tr>
                    <td>
                      <h6 class="mb-0 text-sm"><?php echo e($course->title); ?></h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge bg-gradient-<?php echo e($course->status_badge); ?>"><?php echo e(ucfirst($course->status)); ?></span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-secondary text-xs font-weight-bold"><?php echo e($course->enrollments->count()); ?></span>
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <tr>
                    <td colspan="3" class="text-center">Belum ada kursus</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <?php if($user->role == 'guest'): ?>
        <div class="row mb-4">
          <div class="col-12">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Pendaftaran Kursus</h6>
            <div class="table-responsive mt-3">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progres</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__empty_1 = true; $__currentLoopData = $user->enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <tr>
                    <td>
                      <h6 class="mb-0 text-sm"><?php echo e($enrollment->course->title); ?></h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge bg-gradient-<?php echo e($enrollment->status_badge); ?>"><?php echo e(ucfirst($enrollment->status)); ?></span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-secondary text-xs font-weight-bold"><?php echo e($enrollment->progress); ?>%</span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge bg-gradient-<?php echo e($enrollment->payment_status_badge); ?>"><?php echo e(ucfirst($enrollment->payment_status)); ?></span>
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <tr>
                    <td colspan="4" class="text-center">Belum ada pendaftaran</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/admin/users/show.blade.php ENDPATH**/ ?>