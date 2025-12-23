

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Daftar Kursus</h6>
          <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary btn-sm">Tambah Kursus</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <form method="GET" action="<?php echo e(route('courses.index')); ?>" class="p-3">
            <div class="row">
              <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari kursus..." value="<?php echo e(request('search')); ?>">
              </div>
              <div class="col-md-3">
                <select name="category_id" class="form-control">
                  <option value="">Semua Kategori</option>
                  <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="col-md-3">
                <select name="status" class="form-control">
                  <option value="">Semua Status</option>
                  <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                  <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>>Open</option>
                  <option value="ongoing" <?php echo e(request('status') == 'ongoing' ? 'selected' : ''); ?>>Ongoing</option>
                  <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                  <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
              </div>
            </div>
          </form>
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trainer</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo e($course->title); ?></h6>
                      <p class="text-xs text-secondary mb-0"><?php echo e(Str::limit($course->description, 50)); ?></p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?php echo e($course->category->name); ?></p>
                </td>
                <td class="align-middle text-center text-sm">
                  <p class="text-xs font-weight-bold mb-0"><?php echo e($course->trainer->name); ?></p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-<?php echo e($course->status_badge); ?>"><?php echo e(ucfirst($course->status)); ?></span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($course->enrollments()->where('status', 'approved')->count()); ?>/<?php echo e($course->max_participants); ?></span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">Rp <?php echo e(number_format($course->price, 0, ',', '.')); ?></span>
                </td>
                <td class="align-middle">
                  <a href="<?php echo e(route('courses.show', $course)); ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Lihat">
                    Lihat
                  </a>
                  <a href="<?php echo e(route('courses.edit', $course)); ?>" class="text-secondary font-weight-bold text-xs ms-2" data-toggle="tooltip" data-original-title="Edit">
                    Edit
                  </a>
                  <form action="<?php echo e(route('courses.destroy', $course)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="7" class="text-center">Tidak ada kursus</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          <?php echo e($courses->links()); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/admin/courses/index.blade.php ENDPATH**/ ?>