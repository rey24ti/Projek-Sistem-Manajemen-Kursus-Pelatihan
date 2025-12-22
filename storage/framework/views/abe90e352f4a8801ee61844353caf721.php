

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Daftar Kategori</h6>
          <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary btn-sm">Tambah Kategori</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Kursus</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo e($category->name); ?></h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?php echo e(Str::limit($category->description, 50)); ?></p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($category->courses_count); ?></span>
                </td>
                <td class="align-middle">
                  <a href="<?php echo e(route('categories.edit', $category)); ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                    Edit
                  </a>
                  <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent ms-2" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="4" class="text-center">Tidak ada kategori</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          <?php echo e($categories->links()); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>