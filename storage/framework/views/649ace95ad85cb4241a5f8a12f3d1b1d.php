<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>

<?php if(\Request::is('rtl')): ?>
  <html dir="rtl" lang="ar">
<?php else: ?>
  <html lang="en" >
<?php endif; ?>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php if(env('IS_DEMO')): ?>
      <?php if (isset($component)) { $__componentOriginalb028e3c120f9eb4dcf5f37307a919070 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb028e3c120f9eb4dcf5f37307a919070 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.demo-metas','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('demo-metas'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb028e3c120f9eb4dcf5f37307a919070)): ?>
<?php $attributes = $__attributesOriginalb028e3c120f9eb4dcf5f37307a919070; ?>
<?php unset($__attributesOriginalb028e3c120f9eb4dcf5f37307a919070); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb028e3c120f9eb4dcf5f37307a919070)): ?>
<?php $component = $__componentOriginalb028e3c120f9eb4dcf5f37307a919070; ?>
<?php unset($__componentOriginalb028e3c120f9eb4dcf5f37307a919070); ?>
<?php endif; ?>
  <?php endif; ?>

  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Soft UI Dashboard by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100 <?php echo e((\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : ''))); ?> ">
  <?php if(auth()->guard()->check()): ?>
    <?php echo $__env->yieldContent('auth'); ?>
  <?php endif; ?>
  <?php if(auth()->guard()->guest()): ?>
    <?php echo $__env->yieldContent('guest'); ?>
  <?php endif; ?>

  <?php if(session()->has('success')): ?>
    <div x-data="{ show: true}"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
      <p class="m-0"><?php echo e(session('success')); ?></p>
    </div>
  <?php endif; ?>
    <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/fullcalendar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <?php echo $__env->yieldPushContent('rtl'); ?>
  <?php echo $__env->yieldPushContent('dashboard'); ?>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>
<?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/layouts/app.blade.php ENDPATH**/ ?>