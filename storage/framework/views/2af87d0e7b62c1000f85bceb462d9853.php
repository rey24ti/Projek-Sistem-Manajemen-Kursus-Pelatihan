<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Daftar Kursus Tersedia</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <form method="GET" action="<?php echo e(route('courses.index')); ?>" class="p-3">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="search" class="form-control" placeholder="Cari kursus..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-4">
              <select name="category_id" class="form-control">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
          </div>
        </form>
        <div class="row p-3">
          <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="col-md-6 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo e($course->title); ?></h5>
                <p class="card-text"><?php echo e(Str::limit($course->description, 150)); ?></p>
                <div class="mb-3">
                  <span class="badge bg-gradient-primary"><?php echo e($course->category->name); ?></span>
                  <span class="badge bg-gradient-success">Rp <?php echo e(number_format($course->price, 0, ',', '.')); ?></span>
                  <span class="badge bg-gradient-info"><?php echo e($course->enrollments()->where('status', 'approved')->count()); ?>/<?php echo e($course->max_participants); ?> Peserta</span>
                </div>
                <div class="mb-2">
                  <small class="text-muted">
                    <i class="ni ni-calendar-grid-58"></i> <?php echo e($course->start_date->format('d M Y')); ?> - <?php echo e($course->end_date->format('d M Y')); ?>

                  </small><br>
                  <small class="text-muted">
                    <i class="ni ni-single-02"></i> Trainer: <?php echo e($course->trainer->name); ?>

                  </small>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <a href="<?php echo e(route('courses.show', $course)); ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                  <?php
                    $isEnrolled = \App\Models\Enrollment::where('user_id', auth()->id())
                      ->where('course_id', $course->id)
                      ->exists();
                  ?>
                  <?php if($isEnrolled): ?>
                    <span class="badge bg-gradient-success">Sudah Terdaftar</span>
                  <?php else: ?>
                    <form action="<?php echo e(route('enrollments.register')); ?>" method="POST" class="d-inline">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>">
                      <button type="submit" class="btn btn-sm btn-primary">Daftar Sekarang</button>
                    </form>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="col-12">
            <p class="text-center">Tidak ada kursus tersedia</p>
          </div>
          <?php endif; ?>
        </div>
        <div class="px-3 py-2">
          <?php echo e($courses->links()); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\rey_vinsen_bpf\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/guest/courses/index.blade.php ENDPATH**/ ?>