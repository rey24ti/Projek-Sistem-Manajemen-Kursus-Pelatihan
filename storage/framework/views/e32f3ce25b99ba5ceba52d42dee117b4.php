

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Detail Kursus</h6>
          <div>
            <?php if($course->status === 'pending'): ?>
            <form action="<?php echo e(route('courses.approve', $course)); ?>" method="POST" class="d-inline">
              <?php echo csrf_field(); ?>
              <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve kursus ini dan buka pendaftaran?')">Approve</button>
            </form>
            <?php endif; ?>
            <a href="<?php echo e(route('courses.edit', $course)); ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-sm btn-secondary">Kembali</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <?php if($course->image): ?>
          <div class="col-lg-5 mb-4 mb-lg-0">
            <div style="height: 320px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 0.75rem;">
              <img src="<?php echo e(Storage::url($course->image)); ?>" alt="<?php echo e($course->title); ?>" class="img-fluid" style="max-height: 100%; max-width: 100%; width: auto; height: auto;">
            </div>
          </div>
          <?php endif; ?>

          <div class="<?php echo e($course->image ? 'col-lg-7' : 'col-12'); ?>">
            <h4 class="mb-1"><?php echo e($course->title); ?></h4>
            <p class="text-muted mb-3"><?php echo e($course->description); ?></p>

            <div class="row">
              <div class="col-md-6">
                <ul class="list-group">
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Kategori:</strong> <?php echo e($course->category->name); ?></li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Trainer:</strong> <?php echo e($course->trainer->name); ?></li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Status:</strong> <span class="badge bg-gradient-<?php echo e($course->status_badge); ?>"><?php echo e(ucfirst($course->status)); ?></span></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="list-group">
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Tanggal Mulai:</strong> <?php echo e($course->start_date->format('d M Y')); ?></li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Tanggal Selesai:</strong> <?php echo e($course->end_date->format('d M Y')); ?></li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Harga:</strong> Rp <?php echo e(number_format($course->price, 0, ',', '.')); ?></li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Nilai Minimum Kelulusan:</strong> <?php echo e($course->passing_score ?? 70); ?>%</li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Peserta:</strong> <?php echo e($course->enrollments()->where('status', 'approved')->count()); ?>/<?php echo e($course->max_participants); ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-6 mb-4 mb-md-0">
            <div class="card h-100">
              <div class="card-body">
                <h6>Materi Kursus</h6>
                <a href="<?php echo e(route('materials.index', $course)); ?>" class="btn btn-sm btn-info">Kelola Materi</a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <h6>Peserta Terdaftar</h6>
                <a href="<?php echo e(route('enrollments.index', ['course_id' => $course->id])); ?>" class="btn btn-sm btn-success">Lihat Peserta</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/admin/courses/show.blade.php ENDPATH**/ ?>