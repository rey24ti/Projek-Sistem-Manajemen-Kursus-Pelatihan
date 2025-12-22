@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Pendaftaran Saya</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nilai</th>
                <th class="text-secondary opacity-7">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($enrollments as $enrollment)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $enrollment->course->title }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $enrollment->course->category->name }}</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-{{ $enrollment->status_badge }}">{{ ucfirst($enrollment->status) }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  @if($enrollment->payment_status)
                    <span class="badge badge-sm bg-gradient-{{ $enrollment->payment_status_badge }}">{{ ucfirst($enrollment->payment_status) }}</span>
                    @if($enrollment->payment_status == 'pending')
                      <br><small><a href="{{ route('payments.create', $enrollment) }}" class="text-warning">Upload Bukti</a></small>
                    @endif
                  @else
                    <span class="text-secondary text-xs">-</span>
                  @endif
                </td>
                <td class="align-middle text-center">
                  <div class="progress-wrapper w-75 mx-auto">
                    <div class="progress-info">
                      <div class="progress-percentage">
                        <span class="text-xs font-weight-bold">{{ $enrollment->progress }}%</span>
                      </div>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-info" style="width: {{ $enrollment->progress }}%"></div>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  @if($enrollment->final_score !== null)
                    <span class="text-xs font-weight-bold">{{ number_format($enrollment->final_score, 2) }}</span>
                    @if($enrollment->is_passed)
                      <br><span class="badge badge-sm bg-gradient-success">Lulus</span>
                    @else
                      <br><span class="badge badge-sm bg-gradient-danger">Tidak Lulus</span>
                    @endif
                  @else
                    <span class="text-secondary text-xs">-</span>
                  @endif
                </td>
                <td class="align-middle">
                  <div class="d-flex flex-column gap-1">
                    <a href="{{ route('courses.show', $enrollment->course) }}" class="text-info font-weight-bold text-xs">Kursus</a>
                    @if($enrollment->status == 'approved')
                      <a href="{{ route('courses.student.materials', $enrollment->course) }}" class="text-primary font-weight-bold text-xs">Materi</a>
                      <a href="{{ route('courses.student.assignments', $enrollment->course) }}" class="text-info font-weight-bold text-xs">Tugas</a>
                      @if($enrollment->is_passed && $enrollment->certificate_path)
                        <a href="{{ route('certificates.show', $enrollment) }}" class="text-success font-weight-bold text-xs" target="_blank">Sertifikat</a>
                      @endif
                    @endif
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center">Anda belum terdaftar pada kursus apapun</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          {{ $enrollments->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

