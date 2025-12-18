<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="<?php echo e(route('dashboard')); ?>">
                        <i class="ni ni-shop me-1"></i> Dashboard
                    </a>
                </li>
                <?php if(Request::path() != 'dashboard'): ?>
                <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                    <?php echo e(ucwords(str_replace(['-', '/'], [' ', ' / '], Request::path()))); ?>

                </li>
                <?php endif; ?>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">
                <?php if(Request::path() == 'dashboard'): ?>
                    Dashboard
                <?php else: ?>
                    <?php echo e(ucwords(str_replace(['-', '/'], [' ', ' / '], Request::path()))); ?>

                <?php endif; ?>
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            <ul class="navbar-nav justify-content-end">
                <!-- User Dropdown -->
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-2">
                                <div class="avatar avatar-sm bg-gradient-<?php echo e(auth()->user()->role == 'admin' ? 'primary' : (auth()->user()->role == 'staff' ? 'info' : 'success')); ?> rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="text-white text-sm font-weight-bold"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-start d-none d-md-block">
                                <span class="text-sm font-weight-bold text-dark mb-0"><?php echo e(auth()->user()->name); ?></span>
                                <span class="text-xs text-secondary">
                                    <span class="badge badge-sm bg-gradient-<?php echo e(auth()->user()->role == 'admin' ? 'primary' : (auth()->user()->role == 'staff' ? 'info' : 'success')); ?>">
                                        <?php echo e(ucfirst(auth()->user()->role)); ?>

                                    </span>
                                </span>
                            </div>
                            <i class="fa fa-chevron-down ms-2 text-xs opacity-6"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="userDropdown">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="<?php echo e(url('user-profile')); ?>">
                                <div class="d-flex py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-primary shadow text-center me-3 d-flex align-items-center justify-content-center">
                                        <i class="ni ni-single-02 text-white text-sm"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-0">Profil Saya</h6>
                                        <p class="text-xs text-secondary mb-0">Kelola profil Anda</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="horizontal dark my-2">
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="<?php echo e(url('/logout')); ?>">
                                <div class="d-flex py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-danger shadow text-center me-3 d-flex align-items-center justify-content-center">
                                        <i class="ni ni-user-run text-white text-sm"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-0">Keluar</h6>
                                        <p class="text-xs text-secondary mb-0">Logout dari sistem</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Mobile Menu Toggle -->
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/layouts/navbars/auth/nav.blade.php ENDPATH**/ ?>