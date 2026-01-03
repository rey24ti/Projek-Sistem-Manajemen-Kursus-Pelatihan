@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Laporan Kursus Saya</h6>
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
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Kursus Aktif</p>
                      <h5 class="font-weight-bolder mb-0">{{ $stats['active_courses'] }}</h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                      <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
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
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Kursus Selesai</p>
                      <h5 class="font-weight-bolder mb-0">{{ $stats['completed_courses'] }}</h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                      <i class="ni ni-trophy text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
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
                      </tr>
                      @empty
                      <tr>
                        <td colspan="3" class="text-center text-sm text-secondary py-4">Belum ada pendaftaran.</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header pb-0">
                <h6>Statistik Kursus</h6>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Selesai</th>
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
                      </tr>
                      @empty
                      <tr>
                        <td colspan="3" class="text-center text-sm text-secondary py-4">Belum ada data kursus.</td>
                      </tr>
                      @endforelse
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

