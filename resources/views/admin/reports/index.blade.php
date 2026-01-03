@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Laporan</h6>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Kursus</p>
                      <h5 class="font-weight-bolder mb-0">{{ $stats['total_courses'] }}</h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-book-bookmark text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pendaftaran</p>
                      <h5 class="font-weight-bolder mb-0">{{ $stats['total_enrollments'] }}</h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                      <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Peserta</p>
                      <h5 class="font-weight-bolder mb-0">{{ $stats['total_participants'] }}</h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                      <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Pengguna (Guest)</p>
                      <h5 class="font-weight-bolder mb-0">{{ $stats['total_users'] }}</h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                      <i class="ni ni-circle-08 text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Laporan Keuangan</h6>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="card bg-gradient-success">
              <div class="card-body p-3">
                <p class="text-sm mb-0 text-white">Total Pendapatan</p>
                <h5 class="mb-0 text-white">Rp {{ number_format($financialStats['total_revenue'], 0, ',', '.') }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="card bg-gradient-warning">
              <div class="card-body p-3">
                <p class="text-sm mb-0 text-white">Pendapatan Pending</p>
                <h5 class="mb-0 text-white">Rp {{ number_format($financialStats['pending_revenue'], 0, ',', '.') }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
            <div class="card bg-gradient-info">
              <div class="card-body p-3">
                <p class="text-sm mb-0 text-white">Pembayaran Terverifikasi</p>
                <h5 class="mb-0 text-white">{{ $financialStats['verified_payments'] }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="card bg-gradient-danger">
              <div class="card-body p-3">
                <p class="text-sm mb-0 text-white">Pembayaran Pending</p>
                <h5 class="mb-0 text-white">{{ $financialStats['pending_payments'] }}</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-md-6 mb-4 mb-md-0">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Statistik Progres Belajar</h6>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-6 mb-3">
            <p class="text-sm mb-1">Rata-rata Progres</p>
            <h5 class="mb-0">{{ number_format($progressStats['avg_progress'], 2) }}%</h5>
          </div>
          <div class="col-6 mb-3">
            <p class="text-sm mb-1">Progres Tinggi (≥80%)</p>
            <h5 class="mb-0 text-success">{{ $progressStats['high_progress'] }}</h5>
          </div>
          <div class="col-6">
            <p class="text-sm mb-1">Progres Sedang (50-79%)</p>
            <h5 class="mb-0 text-warning">{{ $progressStats['medium_progress'] }}</h5>
          </div>
          <div class="col-6">
            <p class="text-sm mb-1">Progres Rendah (<50%)</p>
            <h5 class="mb-0 text-danger">{{ $progressStats['low_progress'] }}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Statistik Kelulusan</h6>
      </div>
      <div class="card-body p-3">
        <div class="row">
          <div class="col-6 mb-3">
            <p class="text-sm mb-1">Total Selesai</p>
            <h5 class="mb-0">{{ $graduationStats['total_completed'] }}</h5>
          </div>
          <div class="col-6 mb-3">
            <p class="text-sm mb-1">Lulus</p>
            <h5 class="mb-0 text-success">{{ $graduationStats['total_passed'] }}</h5>
          </div>
          <div class="col-6">
            <p class="text-sm mb-1">Tidak Lulus</p>
            <h5 class="mb-0 text-danger">{{ $graduationStats['total_failed'] }}</h5>
          </div>
          <div class="col-6">
            <p class="text-sm mb-1">Tingkat Kelulusan</p>
            <h5 class="mb-0">{{ number_format($graduationStats['pass_rate'], 2) }}%</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Statistik Detail Kursus</h6>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Peserta</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Selesai</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lulus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rata-rata Progres</th>
              </tr>
            </thead>
            <tbody>
              @forelse($courses as $course)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $course->title }}</h6>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $course->total_enrollments }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $course->completed_enrollments }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-success">{{ $course->passed_enrollments }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-info">{{ $course->paid_enrollments }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ number_format($course->avg_progress ?? 0, 1) }}%</span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center text-sm text-secondary py-4">Belum ada data kursus.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@if(auth()->check() && auth()->user()->isAdmin() && !empty($instructorActivity))
<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Aktivitas Instruktur</h6>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Instruktur</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus Aktif</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Peserta</th>
              </tr>
            </thead>
            <tbody>
              @foreach($instructorActivity as $instructor)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $instructor->name }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $instructor->email }}</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $instructor->courses_count }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-info">{{ $instructor->active_courses_count }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $instructor->enrollments_count }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Pendaftaran Terbaru</h6>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progres</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentEnrollments as $enrollment)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $enrollment->user->name }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $enrollment->user->email }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ $enrollment->course->title }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-{{ $enrollment->status_badge }}">{{ ucfirst($enrollment->status) }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge bg-gradient-{{ $enrollment->payment_status_badge }}">{{ ucfirst($enrollment->payment_status ?? '-') }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ number_format((float)($enrollment->progress ?? 0), 0) }}%</span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center text-sm text-secondary py-4">Belum ada pendaftaran.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection




