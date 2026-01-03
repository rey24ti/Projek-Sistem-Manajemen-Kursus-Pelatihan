

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
            <img src="<?php echo e(Storage::url($course->image)); ?>" alt="<?php echo e($course->title); ?>" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
          </div>
        <?php endif; ?>

        <h4 class="mb-1"><?php echo e($course->title); ?></h4>
        <p class="text-muted mb-0"><?php echo e($course->description); ?></p>

        <div class="row mt-4">
          <div class="col-md-6">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Informasi Kursus</h6>
            <p class="mb-2"><strong>Kategori:</strong> <span class="badge bg-gradient-primary"><?php echo e($course->category->name); ?></span></p>
            <p class="mb-2"><strong>Trainer:</strong> <?php echo e($course->trainer->name); ?></p>
            <p class="mb-2"><strong>Status:</strong> <span class="badge bg-gradient-<?php echo e($course->status_badge); ?>"><?php echo e(ucfirst($course->status)); ?></span></p>
            <?php if($course->passing_score): ?>
              <p class="mb-2"><strong>Nilai Minimum Kelulusan:</strong> <?php echo e($course->passing_score); ?>%</p>
            <?php endif; ?>
          </div>
          <div class="col-md-6">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Jadwal & Detail</h6>
            <p class="mb-2"><strong>Tanggal Mulai:</strong> <?php echo e($course->start_date->format('d F Y')); ?></p>
            <p class="mb-2"><strong>Tanggal Selesai:</strong> <?php echo e($course->end_date->format('d F Y')); ?></p>
            <p class="mb-2"><strong>Harga:</strong> <span class="text-success font-weight-bold">Rp <?php echo e(number_format($course->price, 0, ',', '.')); ?></span></p>
            <p class="mb-2"><strong>Kuota:</strong> <?php echo e($course->enrollments()->where('status', 'approved')->count()); ?>/<?php echo e($course->max_participants); ?> Peserta</p>
          </div>
        </div>

        <?php
          $enrollment = $course->enrollments()->where('user_id', auth()->id())->first();
        ?>

        <?php if($enrollment): ?>
          <div class="alert alert-info mt-4">
            <div>
              <strong>Status Pendaftaran:</strong>
              <span class="badge bg-gradient-<?php echo e($enrollment->status_badge); ?>"><?php echo e(ucfirst($enrollment->status)); ?></span>

              <?php if($enrollment->payment_status): ?>
                | <strong>Pembayaran:</strong>
                <span class="badge bg-gradient-<?php echo e($enrollment->payment_status_badge); ?>"><?php echo e(ucfirst($enrollment->payment_status)); ?></span>
              <?php endif; ?>

              <?php if($enrollment->progress !== null): ?>
                | <strong>Progres:</strong> <?php echo e($enrollment->progress); ?>%
              <?php endif; ?>
            </div>
          </div>

          <?php if($enrollment->status === 'approved'): ?>
            <div class="mt-4">
              <h6>Akses Kursus</h6>
              <div class="row">
                <div class="col-md-3 mb-2">
                  <a href="<?php echo e(route('courses.student.materials', $course)); ?>" class="btn btn-outline-primary w-100">
                    <i class="ni ni-book-bookmark"></i> Materi
                  </a>
                </div>
                <div class="col-md-3 mb-2">
                  <a href="<?php echo e(route('courses.student.assignments', $course)); ?>" class="btn btn-outline-info w-100">
                    <i class="ni ni-paper-diploma"></i> Tugas
                  </a>
                </div>
                <div class="col-md-3 mb-2">
                  <a href="<?php echo e(route('courses.student.quizzes', $course)); ?>" class="btn btn-outline-warning w-100">
                    <i class="ni ni-chart-bar-32"></i> Kuis
                  </a>
                </div>
                <div class="col-md-3 mb-2">
                  <a href="<?php echo e(route('enrollments.index')); ?>" class="btn btn-outline-success w-100">
                    <i class="ni ni-chart-bar-32"></i> Progres
                  </a>
                </div>
              </div>
            </div>

            <?php if($enrollment->is_passed && $enrollment->certificate_path): ?>
              <div class="mt-3">
                <a href="<?php echo e(route('certificates.show', $enrollment)); ?>" class="btn btn-success" target="_blank">
                  <i class="ni ni-trophy"></i> Download Sertifikat
                </a>
              </div>
            <?php endif; ?>
          <?php elseif($enrollment->status === 'pending'): ?>
            <?php if($enrollment->payment_status === 'pending'): ?>
              <div class="mt-4">
                <div class="alert alert-warning">
                  <strong>Pembayaran Belum Diverifikasi</strong><br>
                  Silakan upload bukti pembayaran untuk mempercepat proses verifikasi.
                </div>
                <a href="<?php echo e(route('payments.create', $enrollment)); ?>" class="btn btn-primary">
                  <i class="ni ni-cloud-upload-96"></i> Upload Bukti Pembayaran
                </a>
              </div>
            <?php else: ?>
              <div class="alert alert-info mt-4">
                Pendaftaran Anda sedang menunggu persetujuan dari admin.
              </div>
            <?php endif; ?>
          <?php endif; ?>
        <?php else: ?>
          <?php if($course->status === 'open' && ($course->enrollments()->where('status', 'approved')->count() < $course->max_participants)): ?>
            <form action="<?php echo e(route('enrollments.register')); ?>" method="POST" class="mt-4">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="ni ni-single-02"></i> Daftar Sekarang
              </button>
            </form>
          <?php else: ?>
            <div class="alert alert-secondary mt-4">
              <?php if($course->status !== 'open'): ?>
                Kursus ini tidak sedang membuka pendaftaran.
              <?php else: ?>
                Kursus sudah penuh.
              <?php endif; ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($course->materials->count() > 0 || $course->assignments->count() > 0 || $course->quizzes->count() > 0): ?>
          <div class="mt-4">
            <h6>Isi Kursus</h6>
            <div class="row">
              <?php if($course->materials->count() > 0): ?>
                <div class="col-md-4 mb-2">
                  <div class="card">
                    <div class="card-body text-center">
                      <i class="ni ni-book-bookmark text-primary" style="font-size: 2rem;"></i>
                      <h6 class="mt-2"><?php echo e($course->materials->count()); ?> Materi</h6>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              <?php if($course->assignments->count() > 0): ?>
                <div class="col-md-4 mb-2">
                  <div class="card">
                    <div class="card-body text-center">
                      <i class="ni ni-paper-diploma text-info" style="font-size: 2rem;"></i>
                      <h6 class="mt-2"><?php echo e($course->assignments->count()); ?> Tugas</h6>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              <?php if($course->quizzes->count() > 0): ?>
                <div class="col-md-4 mb-2">
                  <div class="card">
                    <div class="card-body text-center">
                      <i class="ni ni-chart-bar-32 text-warning" style="font-size: 2rem;"></i>
                      <h6 class="mt-2"><?php echo e($course->quizzes->count()); ?> Kuis</h6>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/guest/courses/auth_show.blade.php ENDPATH**/ ?>