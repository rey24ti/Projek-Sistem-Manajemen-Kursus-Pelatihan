

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Upload Bukti Pembayaran</h6>
      </div>
      <div class="card-body">
        <?php if($errors->any()): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>

        <form action="<?php echo e(route('payments.store', $enrollment)); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>

          <p class="text-sm text-muted"><strong>Kursus:</strong> <?php echo e($course->title); ?></p>
          <p class="text-sm text-muted"><strong>Harga:</strong> Rp <?php echo e(number_format($course->price, 0, ',', '.')); ?></p>

          <?php if (! (auth()->check())): ?>
          <div class="mb-3">
            <label class="form-label">Email Pendaftar</label>
            <input type="email" name="owner_email" value="<?php echo e(old('owner_email')); ?>" class="form-control" required>
            <small class="text-muted">Masukkan email yang digunakan saat mendaftar</small>
          </div>
          <?php endif; ?>

          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="payment_method" class="form-control" required>
              <option value="transfer">Transfer</option>
              <option value="cash">Cash</option>
              <option value="other">Lainnya</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Bukti (foto/scan)</label>
            <input type="file" name="proof" class="form-control" accept="image/*" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control"><?php echo e(old('notes')); ?></textarea>
          </div>

          <div class="mb-3 d-flex gap-2">
            <button class="btn btn-primary" type="submit">Upload</button>
            <a href="<?php echo e(route('enrollments.index')); ?>" class="btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/guest/payments/create.blade.php ENDPATH**/ ?>