

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Detail Kursus</h6>
          <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-sm btn-secondary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <?php if($course->image): ?>
        <div class="mb-3">
          <img src="<?php echo e(Storage::url($course->image)); ?>" alt="<?php echo e($course->title); ?>" class="img-fluid" style="max-height: 300px;">
        </div>
        <?php endif; ?>
        <h4><?php echo e($course->title); ?></h4>
        <p class="text-muted"><?php echo e($course->description); ?></p>
        <div class="row mt-4">
          <div class="col-md-6">
            <p><strong>Kategori:</strong> <?php echo e($course->category->name); ?></p>
            <p><strong>Status:</strong> <span class="badge bg-gradient-<?php echo e($course->status_badge); ?>"><?php echo e(ucfirst($course->status)); ?></span></p>
          </div>
          <div class="col-md-6">
            <p><strong>Tanggal Mulai:</strong> <?php echo e($course->start_date->format('d M Y')); ?></p>
            <p><strong>Tanggal Selesai:</strong> <?php echo e($course->end_date->format('d M Y')); ?></p>
            <p><strong>Peserta:</strong> <?php echo e($course->enrollments()->where('status', 'approved')->count()); ?>/<?php echo e($course->max_participants); ?></p>
          </div>
        </div>
        <div class="mt-4">
          <a href="<?php echo e(route('materials.index', $course)); ?>" class="btn btn-info">Kelola Materi</a>
          <a href="<?php echo e(route('enrollments.index', ['course_id' => $course->id])); ?>" class="btn btn-success">Lihat Peserta</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/staff/courses/show.blade.php ENDPATH**/ ?>