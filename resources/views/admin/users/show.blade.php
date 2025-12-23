@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Detail Pengguna</h6>
          <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Informasi Pribadi</h6>
            <div class="mt-3">
              <p class="text-sm mb-2"><strong>Nama:</strong> {{ $user->name }}</p>
              <p class="text-sm mb-2"><strong>Email:</strong> {{ $user->email }}</p>
              <p class="text-sm mb-2"><strong>Role:</strong> 
                @if($user->role == 'staff')
                  <span class="badge bg-gradient-info">Instruktur</span>
                @elseif($user->role == 'guest')
                  <span class="badge bg-gradient-success">Peserta</span>
                @else
                  <span class="badge bg-gradient-primary">Admin</span>
                @endif
              </p>
              <p class="text-sm mb-2"><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</p>
              <p class="text-sm mb-2"><strong>Lokasi:</strong> {{ $user->location ?? '-' }}</p>
              @if($user->about_me)
              <p class="text-sm mb-2"><strong>Tentang:</strong> {{ $user->about_me }}</p>
              @endif
            </div>
          </div>
        </div>

        @if($user->role == 'staff')
        <div class="row mb-4">
          <div class="col-12">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Kursus yang Diajarkan</h6>
            <div class="table-responsive mt-3">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul Kursus</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($user->courses as $course)
                  <tr>
                    <td>
                      <h6 class="mb-0 text-sm">{{ $course->title }}</h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge bg-gradient-{{ $course->status_badge }}">{{ ucfirst($course->status) }}</span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-secondary text-xs font-weight-bold">{{ $course->enrollments->count() }}</span>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="3" class="text-center">Belum ada kursus</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif

        @if($user->role == 'guest')
        <div class="row mb-4">
          <div class="col-12">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Pendaftaran Kursus</h6>
            <div class="table-responsive mt-3">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progres</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($user->enrollments as $enrollment)
                  <tr>
                    <td>
                      <h6 class="mb-0 text-sm">{{ $enrollment->course->title }}</h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge bg-gradient-{{ $enrollment->status_badge }}">{{ ucfirst($enrollment->status) }}</span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-secondary text-xs font-weight-bold">{{ $enrollment->progress }}%</span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge bg-gradient-{{ $enrollment->payment_status_badge }}">{{ ucfirst($enrollment->payment_status) }}</span>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center">Belum ada pendaftaran</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection


