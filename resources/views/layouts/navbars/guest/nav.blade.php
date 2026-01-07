<!-- Navbar -->
<nav class="navbar navbar-expand-lg position-relative z-index-3 my-2 guest-navbar blur blur-rounded shadow py-1">
  <div class="container-fluid">
    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="{{ url('/') }}">
      Trainify
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
        @auth
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center me-2" aria-current="page" href="{{ url('dashboard') }}">
              <i class="fa fa-chart-pie opacity-6 me-1 text-dark"></i>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="{{ url('user-profile') }}">
              <i class="fa fa-user opacity-6 me-1 text-dark"></i>
              Profil
            </a>
          </li>
        @endauth
        @guest
          <li class="nav-item">
            <a class="nav-link me-2" href="{{ url('register') }}">
              <i class="fas fa-user-circle opacity-6 me-1 text-dark"></i>
              Daftar
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="{{ url('login') }}">
              <i class="fas fa-key opacity-6 me-1 text-dark"></i>
              Masuk
            </a>
          </li>
        @endguest
      </ul>
      <ul class="navbar-nav d-lg-block d-none">
        <li class="nav-item">

        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
