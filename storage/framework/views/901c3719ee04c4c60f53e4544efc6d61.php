<?php $__env->startSection('content'); ?>

<?php if(auth()->user()->isAdmin() || auth()->user()->isStaff()): ?>
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Kursus</p>
                <h5 class="font-weight-bolder mb-0">
                  <?php echo e(\App\Models\Course::when(auth()->user()->isStaff(), fn($q) => $q->where('trainer_id', auth()->id()))->count()); ?>

                </h5>
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
                <h5 class="font-weight-bolder mb-0">
                  <?php echo e(\App\Models\Enrollment::when(auth()->user()->isStaff(), fn($q) => $q->whereHas('course', fn($c) => $c->where('trainer_id', auth()->id())))->count()); ?>

                </h5>
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Kursus Aktif</p>
                <h5 class="font-weight-bolder mb-0">
                  <?php echo e(\App\Models\Course::where('status', 'ongoing')->when(auth()->user()->isStaff(), fn($q) => $q->where('trainer_id', auth()->id()))->count()); ?>

                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Kursus Selesai</p>
                <h5 class="font-weight-bolder mb-0">
                  <?php echo e(\App\Models\Course::where('status', 'completed')->when(auth()->user()->isStaff(), fn($q) => $q->where('trainer_id', auth()->id()))->count()); ?>

                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                <i class="ni ni-trophy text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <h6>Kursus Terbaru</h6>
            <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = \App\Models\Course::with('category')->when(auth()->user()->isStaff(), fn($q) => $q->where('trainer_id', auth()->id()))->latest()->limit(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm"><?php echo e($course->title); ?></h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0"><?php echo e($course->category->name); ?></p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm bg-gradient-<?php echo e($course->status_badge); ?>"><?php echo e(ucfirst($course->status)); ?></span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold"><?php echo e($course->enrollments()->where('status', 'approved')->count()); ?>/<?php echo e($course->max_participants); ?></span>
                  </td>
                  <td class="align-middle">
                    <a href="<?php echo e(route('courses.show', $course)); ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                      Lihat
                    </a>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="5" class="text-center">Tidak ada kursus</td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Selamat Datang</h6>
        </div>
        <div class="card-body">
          <p>Selamat datang di Sistem Manajemen Kursus. Silakan jelajahi kursus yang tersedia dan daftar untuk mengikuti pelatihan.</p>
          <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-primary">Lihat Kursus</a>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\rey_vinsen_bpf\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/dashboard.blade.php ENDPATH**/ ?>