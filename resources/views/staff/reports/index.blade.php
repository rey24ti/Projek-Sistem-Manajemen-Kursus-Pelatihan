@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Laporan Kursus Saya</h6>
      </div>
      <div class="card-body">
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
                <h6 class="text-sm mb-0">Kursus Aktif</h6>
                <h3 class="mb-0">{{ $stats['active_courses'] }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h6 class="text-sm mb-0">Kursus Selesai</h6>
                <h3 class="mb-0">{{ $stats['completed_courses'] }}</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h6>Pendaftaran Terbaru</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th>Peserta</th>
                        <th>Kursus</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($recentEnrollments as $enrollment)
                      <tr>
                        <td>{{ $enrollment->user->name }}</td>
                        <td>{{ $enrollment->course->title }}</td>
                        <td><span class="badge bg-gradient-{{ $enrollment->status_badge }}">{{ ucfirst($enrollment->status) }}</span></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h6>Statistik Kursus</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th>Kursus</th>
                        <th>Peserta</th>
                        <th>Selesai</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($courses as $course)
                      <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->total_enrollments }}</td>
                        <td>{{ $course->completed_enrollments }}</td>
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

