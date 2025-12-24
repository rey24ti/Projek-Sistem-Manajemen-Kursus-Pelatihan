
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
        <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="...">
        <span class="ms-3 font-weight-bold">Soft UI Dashboard Laravel</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ url('dashboard') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-shop text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      @if(auth()->check() && auth()->user()->isAdmin())
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('courses*') ? 'active' : '') }}" href="{{ route('courses.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-book-bookmark text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Kursus</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('categories*') ? 'active' : '') }}" href="{{ route('categories.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-tag text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Kategori</span>
        </a>
      </li>
      <li class="nav-item">


        <a class="nav-link {{ (Request::is('users*') ? 'active' : '') }}" href="{{ route('users.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-circle-08 text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Pengguna</span>
        </a>
      </li>
      <li class="nav-item">

        <a class="nav-link {{ (Request::is('enrollments*') ? 'active' : '') }}" href="{{ route('enrollments.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-single-02 text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Pendaftaran</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('reports*') ? 'active' : '') }}" href="{{ route('reports.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-chart-bar-32 text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Laporan</span>
        </a>
      </li>
      @elseif(auth()->user()->isStaff())
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Kursus Saya</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('courses*') ? 'active' : '') }}" href="{{ route('courses.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-book-bookmark text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Kursus</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('enrollments*') ? 'active' : '') }}" href="{{ route('enrollments.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-single-02 text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Peserta</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('reports*') ? 'active' : '') }}" href="{{ route('reports.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-chart-bar-32 text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Laporan</span>
        </a>
      </li>
      @else
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Kursus</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('courses*') ? 'active' : '') }}" href="{{ route('courses.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-book-bookmark text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Daftar Kursus</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('enrollments*') ? 'active' : '') }}" href="{{ route('enrollments.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-single-02 text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Pendaftaran Saya</span>
        </a>
      </li>
      @endif
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('user-profile') ? 'active' : '') }}" href="{{ url('user-profile') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="min-width: 32px; min-height: 32px;">
            <i class="ni ni-single-02 text-dark text-sm"></i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
    </ul>
  </div>
  <div class="sidenav-footer mx-3 "></div>
</aside>
