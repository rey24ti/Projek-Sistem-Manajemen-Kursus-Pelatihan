@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Laporan Sistem</h6>
      </div>
      <div class="card-body">
        <!-- Overview Stats -->
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Total Kursus</h6>
                <h3 class="mb-0">{{ $stats['total_courses'] }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Total Pendaftaran</h6>
                <h3 class="mb-0">{{ $stats['total_enrollments'] }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Total Peserta</h6>
                <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Kursus Aktif</h6>
                <h3 class="mb-0">{{ $stats['active_courses'] }}</h3>
              </div>
            </div>
          </div>
        </div>

        <!-- Financial Stats -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6>Laporan Keuangan</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="card bg-gradient-success">
                      <div class="card-body">
                        <h6 class="text-sm mb-0 text-white">Total Pendapatan</h6>
                        <h4 class="mb-0 text-white">Rp {{ number_format($financialStats['total_revenue'], 0, ',', '.') }}</h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-gradient-warning">
                      <div class="card-body">
                        <h6 class="text-sm mb-0 text-white">Pendapatan Pending</h6>
                        <h4 class="mb-0 text-white">Rp {{ number_format($financialStats['pending_revenue'], 0, ',', '.') }}</h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-gradient-info">
                      <div class="card-body">
                        <h6 class="text-sm mb-0 text-white">Pembayaran Terverifikasi</h6>
                        <h4 class="mb-0 text-white">{{ $financialStats['verified_payments'] }}</h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-gradient-danger">
                      <div class="card-body">
                        <h6 class="text-sm mb-0 text-white">Pembayaran Pending</h6>
                        <h4 class="mb-0 text-white">{{ $financialStats['pending_payments'] }}</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Progress Stats -->
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h6>Statistik Progres Belajar</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Rata-rata Progres</h6>
                    <h4>{{ number_format($progressStats['avg_progress'], 2) }}%</h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Progres Tinggi (≥80%)</h6>
                    <h4 class="text-success">{{ $progressStats['high_progress'] }}</h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Progres Sedang (50-79%)</h6>
                    <h4 class="text-warning">{{ $progressStats['medium_progress'] }}</h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Progres Rendah (<50%)</h6>
                    <h4 class="text-danger">{{ $progressStats['low_progress'] }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Graduation Stats -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h6>Statistik Kelulusan</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Total Selesai</h6>
                    <h4>{{ $graduationStats['total_completed'] }}</h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Lulus</h6>
                    <h4 class="text-success">{{ $graduationStats['total_passed'] }}</h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Tidak Lulus</h6>
                    <h4 class="text-danger">{{ $graduationStats['total_failed'] }}</h4>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6 class="text-sm">Tingkat Kelulusan</h6>
                    <h4>{{ number_format($graduationStats['pass_rate'], 2) }}%</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Course Details -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6>Statistik Detail Kursus</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
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
                      @foreach($courses as $course)
                      <tr>
                        <td>
                          <h6 class="mb-0 text-sm">{{ $course->title }}</h6>
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
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Instructor Activity (Admin Only) -->
        @if(auth()->user()->isAdmin() && isset($instructorActivity))
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6>Aktivitas Instruktur</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Instruktur</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Kursus</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus Aktif</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Peserta</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($instructorActivity as $instructor)
                      <tr>
                        <td>
                          <h6 class="mb-0 text-sm">{{ $instructor->name }}</h6>
                          <p class="text-xs text-secondary mb-0">{{ $instructor->email }}</p>
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

        <!-- Recent Enrollments -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6>Pendaftaran Terbaru</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
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
                      @foreach($recentEnrollments as $enrollment)
                      <tr>
                        <td>
                          <h6 class="mb-0 text-sm">{{ $enrollment->user->name }}</h6>
                          <p class="text-xs text-secondary mb-0">{{ $enrollment->user->email }}</p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{ $enrollment->course->title }}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="badge bg-gradient-{{ $enrollment->status_badge }}">{{ ucfirst($enrollment->status) }}</span>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="badge bg-gradient-{{ $enrollment->payment_status_badge }}">{{ ucfirst($enrollment->payment_status) }}</span>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="text-secondary text-xs font-weight-bold">{{ $enrollment->progress }}%</span>
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
      </div>
    </div>
  </div>
</div>
@endsection
