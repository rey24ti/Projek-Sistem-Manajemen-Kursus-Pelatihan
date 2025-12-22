<?php $__env->startSection('content'); ?>

  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Selamat Datang</h3>
                  <p class="mb-0">Masuk ke akun Anda untuk melanjutkan</p>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="/session" autocomplete="off" id="loginForm">
                    <?php echo csrf_field(); ?>
                    <label class="form-label">Email</label>
                    <div class="mb-3">
                      <input 
                        type="email" 
                        class="form-control" 
                        name="email" 
                        id="email" 
                        placeholder="Masukkan email Anda" 
                        aria-label="Email" 
                        aria-describedby="email-addon" 
                        autocomplete="off"
                        autofill="off"
                        data-form-type="other"
                        required>
                      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <label class="form-label">Password</label>
                    <div class="mb-3">
                      <input 
                        type="password" 
                        class="form-control" 
                        name="password" 
                        id="password" 
                        placeholder="Masukkan password Anda" 
                        aria-label="Password" 
                        aria-describedby="password-addon" 
                        autocomplete="new-password"
                        autofill="off"
                        data-form-type="other"
                        required>
                      <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-danger text-xs mt-2"><?php echo e($message); ?></p>
                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                      <label class="form-check-label" for="rememberMe">Ingat saya</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Masuk</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <small class="text-muted">Lupa password? Reset password Anda 
                    <a href="/login/forgot-password" class="text-info text-gradient font-weight-bold">di sini</a>
                  </small>
                  <p class="mb-4 text-sm mx-auto mt-2">
                    Belum punya akun?
                    <a href="<?php echo e(route('register')); ?>" class="text-info text-gradient font-weight-bold">Daftar</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script>
    // Prevent browser autofill
    document.addEventListener('DOMContentLoaded', function() {
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      
      // Clear any autofilled values
      setTimeout(function() {
        if (emailInput.value && !emailInput.dataset.userInput) {
          emailInput.value = '';
        }
        if (passwordInput.value && !passwordInput.dataset.userInput) {
          passwordInput.value = '';
        }
      }, 100);
      
      // Track user input
      emailInput.addEventListener('input', function() {
        this.dataset.userInput = 'true';
      });
      
      passwordInput.addEventListener('input', function() {
        this.dataset.userInput = 'true';
      });
      
      // Prevent autocomplete dropdown
      emailInput.addEventListener('focus', function() {
        this.setAttribute('autocomplete', 'off');
      });
      
      passwordInput.addEventListener('focus', function() {
        this.setAttribute('autocomplete', 'new-password');
      });
    });
  </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user_type.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\BPF_PIDOO\laragon-6.0-minimal\www\Projek-Sistem-Manajemen-Kursus-Pelatihan\resources\views/session/login-session.blade.php ENDPATH**/ ?>