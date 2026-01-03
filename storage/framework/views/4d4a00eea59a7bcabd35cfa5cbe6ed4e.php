

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Laporan</h6>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Kursus</p>
                      <h5 class="font-weight-bolder mb-0"><?php echo e($stats['total_courses']); ?></h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-book-bookmark text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pendaftaran</p>
                      <h5 class="font-weight-bolder mb-0"><?php echo e($stats['total_enrollments']); ?></h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                      <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Peserta</p>
                      <h5 class="font-weight-bolder mb-0"><?php echo e($stats['total_participants']); ?></h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                      <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Pengguna (Guest)</p>
                      <h5 class="font-weight-bolder mb-0"><?php echo e($stats['total_users']); ?></h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                      <i class="ni ni-circle-08 text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Laporan Keuangan</h6>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="card bg-gradient-success">
              <div class="card-body p-3">
                <p class="text-sm mb-0 text-white">Total Pendapatan</p>
                <h5 class="mb-0 text-white">Rp <?php echo e(number_format($financialStats['total_revenue'], 0, ',', '.')); ?></h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="card bg-gradient-warning">
              <div class="card-body p-3">
                <p class="text-sm mb-0 text-white">Pendapatan Pending</p>
                <h5 class="mb-0 text-white">Rp <?php echo e(number_format($financialStats['pending_revenue'], 0, ',', '.')); ?></h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="card bg-gradient-info">
              <div class="card-body p-3">
                <p class="text-sm mb-0 text-white">Pembayaran Terverifikasi</p>
                <h5 class="mb-0 text-white"><?php echo e($financialStats['verified_payments']); ?></h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="card bg-gradient-danger">
              <div class="card-body p-3">
                <p class="text-sm mb-0 text-white">Pembayaran Pending</p>
                <h5 class="mb-0 text-white"><?php echo e($financialStats['pending_payments']); ?></h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-md-6 mb-4 mb-md-0">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Statistik Progres Belajar</h6>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-6 mb-3">
            <p class="text-sm mb-1">Rata-rata Progres</p>
            <h5 class="mb-0"><?php echo e(number_format($progressStats['avg_progress'], 2)); ?>%</h5>
          </div>
          <div class="col-6 mb-3">
            <p class="text-sm mb-1">Progres Tinggi (≥80%)</p>
            <h5 class="mb-0 text-success"><?php echo e($progressStats['high_progress']); ?></h5>
          </div>
          <div class="col-6">
            <p class="text-sm mb-1">Progres Sedang (50-79%)</p>
            <h5 class="mb-0 text-warning"><?php echo e($progressStats['medium_progress']); ?></h5>
          </div>
          <div class="col-6">
            <p class="text-sm mb-1">Progres Rendah (<50%)</p>
            <h5 class="mb-0 text-danger"><?php echo e($progressStats['low_progress']); ?></h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Statistik Kelulusan</h6>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-6 mb-3">
            <p class="text-sm mb-1">Total Selesai</p>
            <h5 class="mb-0"><?php echo e($graduationStats['total_completed']); ?></h5>
          </div>
          <div class="col-6 mb-3">
            <p class="text-sm mb-1">Lulus</p>
            <h5 class="mb-0 text-success"><?php echo e($graduationStats['total_passed']); ?></h5>
          </div>
          <div class="col-6">
            <p class="text-sm mb-1">Tidak Lulus</p>
            <h5 class="mb-0 text-danger"><?php echo e($graduationStats['total_failed']); ?></h5>
          </div>
          <div class="col-6">
            <p class="text-sm mb-1">Tingkat Kelulusan</p>
            <h5 class="mb-0"><?php echo e(number_format($graduationStats['pass_rate'], 2)); ?>%</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Statistik Detail Kursus</h6>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Peserta</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Selesai</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lulus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rata-rata Progres</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo e($course->title); ?></h6>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($course->total_enrollments); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($course->completed_enrollments); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-success"><?php echo e($course->passed_enrollments); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-info"><?php echo e($course->paid_enrollments); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e(number_format($course->avg_progress ?? 0, 1)); ?>%</span>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="6" class="text-center text-sm text-secondary py-4">Belum ada data kursus.</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if(auth()->check() && auth()->user()->isAdmin() && !empty($instructorActivity)): ?>
<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Aktivitas Instruktur</h6>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Instruktur</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus Aktif</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Peserta</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $instructorActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo e($instructor->name); ?></h6>
                      <p class="text-xs text-secondary mb-0"><?php echo e($instructor->email); ?></p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($instructor->courses_count); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-info"><?php echo e($instructor->active_courses_count); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($instructor->enrollments_count); ?></span>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Pendaftaran Terbaru</h6>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progres</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $recentEnrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo e($enrollment->user->name); ?></h6>
                      <p class="text-xs text-secondary mb-0"><?php echo e($enrollment->user->email); ?></p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0"><?php echo e($enrollment->course->title); ?></p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-<?php echo e($enrollment->status_badge); ?>"><?php echo e(ucfirst($enrollment->status)); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-<?php echo e($enrollment->payment_status_badge); ?>"><?php echo e(ucfirst($enrollment->payment_status ?? '-')); ?></span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e(number_format((float)($enrollment->progress ?? 0), 0)); ?>%</span>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="5" class="text-center text-sm text-secondary py-4">Belum ada pendaftaran.</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>