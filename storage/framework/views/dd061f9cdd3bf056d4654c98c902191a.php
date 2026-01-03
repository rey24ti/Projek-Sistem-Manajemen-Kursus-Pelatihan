<!-- Navbar -->
<nav class="navbar navbar-expand-lg position-relative z-index-3 my-2 guest-navbar <?php echo e((Request::is('static-sign-up') ? 'w-100 shadow-none navbar-transparent mt-4' : 'blur blur-rounded shadow py-1')); ?>">
  <div class="container-fluid <?php echo e((Request::is('static-sign-up') ? 'container' : 'container-fluid')); ?>">
    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 <?php echo e((Request::is('static-sign-up') ? 'text-white' : '')); ?>" href="<?php echo e(url('dashboard')); ?>">
      Soft UI Dashboard Laravel
    </a>
    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon mt-2">
        <span class="navbar-toggler-bar bar1"></span>
        <span class="navbar-toggler-bar bar2"></span>
        <span class="navbar-toggler-bar bar3"></span>
      </span>
    </button>
    <div class="collapse navbar-collapse" id="navigation">
      <ul class="navbar-nav ms-auto">
        <?php if(auth()->user()): ?>
            <li class="nav-item">
            <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="<?php echo e(url('dashboard')); ?>">
                <i class="fa fa-chart-pie opacity-6 me-1 <?php echo e((Request::is('static-sign-up') ? '' : 'text-dark')); ?>"></i>
                Dashboard
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link me-2" href="<?php echo e(url('profile')); ?>">
                <i class="fa fa-user opacity-6 me-1 <?php echo e((Request::is('static-sign-up') ? '' : 'text-dark')); ?>"></i>
                Profile
            </a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link me-2" href="<?php echo e(auth()->user() ? url('static-sign-up') : url('register')); ?>">
            <i class="fas fa-user-circle opacity-6 me-1 <?php echo e((Request::is('static-sign-up') ? '' : 'text-dark')); ?>"></i>
            Sign Up
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="<?php echo e(auth()->user() ? url('static-sign-in') : url('login')); ?>">
            <i class="fas fa-key opacity-6 me-1 <?php echo e((Request::is('static-sign-up') ? '' : 'text-dark')); ?>"></i>
            Sign In
          </a>
        </li>
      </ul>
      <ul class="navbar-nav d-lg-block d-none">
        <li class="nav-item">

        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
<?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/layouts/navbars/guest/nav.blade.php ENDPATH**/ ?>