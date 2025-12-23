

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Kursus Saya</h6>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <form method="GET" action="<?php echo e(route('courses.index')); ?>" class="p-3">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="search" class="form-control" placeholder="Cari kursus..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
              <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>>Open</option>
                <option value="ongoing" <?php echo e(request('status') == 'ongoing' ? 'selected' : ''); ?>>Ongoing</option>
                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
              </select>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
          </div>
        </form>
        <div class="row p-3">
          <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              <?php if($course->image): ?>
              <img src="<?php echo e(Storage::url($course->image)); ?>" class="card-img-top" alt="<?php echo e($course->title); ?>" style="height: 200px; object-fit: cover;">
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title"><?php echo e($course->title); ?></h5>
                <p class="card-text text-sm"><?php echo e(Str::limit($course->description, 100)); ?></p>
                <p class="text-xs text-secondary mb-2">
                  <strong>Kategori:</strong> <?php echo e($course->category->name); ?><br>
                  <strong>Status:</strong> <span class="badge badge-sm bg-gradient-<?php echo e($course->status_badge); ?>"><?php echo e(ucfirst($course->status)); ?></span><br>
                  <strong>Peserta:</strong> <?php echo e($course->enrollments()->where('status', 'approved')->count()); ?>/<?php echo e($course->max_participants); ?>

                </p>
              </div>
              <div class="card-footer">
                <div class="d-flex justify-content-between">
                  <a href="<?php echo e(route('courses.show', $course)); ?>" class="btn btn-sm btn-primary">Detail</a>
                  <a href="<?php echo e(route('materials.index', $course)); ?>" class="btn btn-sm btn-info">Materi</a>
                  <a href="<?php echo e(route('enrollments.index', ['course_id' => $course->id])); ?>" class="btn btn-sm btn-success">Peserta</a>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="col-12">
            <p class="text-center">Tidak ada kursus</p>
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


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/staff/courses/index.blade.php ENDPATH**/ ?>