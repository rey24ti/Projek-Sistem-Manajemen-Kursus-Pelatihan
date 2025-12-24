

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">

        <h6>Laporan</h6>
      </div>
      <div class="card-body">

        <h6>Laporan Sistem</h6>
      </div>
      <div class="card-body">
        <!-- Overview Stats -->

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

                <h6 class="text-sm mb-0">Total Peserta</h6>
                <h3 class="mb-0"><?php echo e($stats['total_users']); ?></h3>

              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">

                <h6 class="text-sm mb-0">Kursus Selesai</h6>
                <h3 class="mb-0"><?php echo e($stats['completed_courses']); ?></h3>

                <h6 class="text-sm mb-0">Kursus Aktif</h6>
                <h3 class="mb-0"><?php echo e($stats['active_courses']); ?></h3>

              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">


        <!-- Financial Stats -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6>Laporan Keuangan</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="card bg-gradient-success">
                      <div class="card-body">
                        <h6 class="text-sm mb-0 text-white">Total Pendapatan</h6>
                        <h4 class="mb-0 text-white">Rp <?php echo e(number_format($financialStats['total_revenue'], 0, ',', '.')); ?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-gradient-warning">
                      <div class="card-body">
                        <h6 class="text-sm mb-0 text-white">Pendapatan Pending</h6>
                        <h4 class="mb-0 text-white">Rp <?php echo e(number_format($financialStats['pending_revenue'], 0, ',', '.')); ?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-gradient-info">
                      <div class="card-body">
                        <h6 class="text-sm mb-0 text-white">Pembayaran Terverifikasi</h6>
                        <h4 class="mb-0 text-white"><?php echo e($financialStats['verified_payments']); ?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-gradient-danger">
                      <div class="card-body">
                        <h6 class="text-sm mb-0 text-white">Pembayaran Pending</h6>
                        <h4 class="mb-0 text-white"><?php echo e($financialStats['pending_payments']); ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Progress Stats -->
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h6>Statistik Progres Belajar</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Rata-rata Progres</h6>
                    <h4><?php echo e(number_format($progressStats['avg_progress'], 2)); ?>%</h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Progres Tinggi (≥80%)</h6>
                    <h4 class="text-success"><?php echo e($progressStats['high_progress']); ?></h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Progres Sedang (50-79%)</h6>
                    <h4 class="text-warning"><?php echo e($progressStats['medium_progress']); ?></h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Progres Rendah (<50%)</h6>
                    <h4 class="text-danger"><?php echo e($progressStats['low_progress']); ?></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Graduation Stats -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h6>Statistik Kelulusan</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Total Selesai</h6>
                    <h4><?php echo e($graduationStats['total_completed']); ?></h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Lulus</h6>
                    <h4 class="text-success"><?php echo e($graduationStats['total_passed']); ?></h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Tidak Lulus</h6>
                    <h4 class="text-danger"><?php echo e($graduationStats['total_failed']); ?></h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Tingkat Kelulusan</h6>
                    <h4><?php echo e(number_format($graduationStats['pass_rate'], 2)); ?>%</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Course Details -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6>Statistik Detail Kursus</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
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
                      <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td>
                          <h6 class="mb-0 text-sm"><?php echo e($course->title); ?></h6>
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
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Instructor Activity (Admin Only) -->
        <?php if(auth()->check() && auth()->user()->isAdmin() && isset($instructorActivity)): ?>
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6>Aktivitas Instruktur</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Instruktur</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Kursus</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus Aktif</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Peserta</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $instructorActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td>
                          <h6 class="mb-0 text-sm"><?php echo e($instructor->name); ?></h6>
                          <p class="text-xs text-secondary mb-0"><?php echo e($instructor->email); ?></p>
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

        <!-- Recent Enrollments -->
        <div class="row">
          <div class="col-12">
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

                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progres</th>

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