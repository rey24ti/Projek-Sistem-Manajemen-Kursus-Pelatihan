

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Daftar Pengguna</h6>
          <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary btn-sm">Tambah Pengguna</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="px-3 mb-3">
          <form action="<?php echo e(route('users.index')); ?>" method="GET" class="row g-3">
            <div class="col-md-4">
              <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
              <select name="role" class="form-control">
                <option value="">Semua Role</option>
                <option value="staff" <?php echo e(request('role') == 'staff' ? 'selected' : ''); ?>>Instruktur</option>
                <option value="guest" <?php echo e(request('role') == 'guest' ? 'selected' : ''); ?>>Peserta</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary">Cari</button>
              <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Reset</a>
            </div>
          </form>
        </div>
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Telepon</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo e($user->name); ?></h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?php echo e($user->email); ?></p>
                </td>
                <td class="align-middle text-center text-sm">
                  <?php if($user->role == 'staff'): ?>
                    <span class="badge bg-gradient-info">Instruktur</span>
                  <?php elseif($user->role == 'guest'): ?>
                    <span class="badge bg-gradient-success">Peserta</span>
                  <?php else: ?>
                    <span class="badge bg-gradient-primary">Admin</span>
                  <?php endif; ?>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo e($user->phone ?? '-'); ?></span>
                </td>
                <td class="align-middle">
                  <a href="<?php echo e(route('users.show', $user)); ?>" class="text-info font-weight-bold text-xs me-2" data-toggle="tooltip" data-original-title="Detail">Detail</a>
                  <?php if(!$user->isAdmin()): ?>
                    <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" data-original-title="Edit">Edit</a>
                    <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="5" class="text-center">Tidak ada pengguna</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          <?php echo e($users->links()); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user_type.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/admin/users/index.blade.php ENDPATH**/ ?>