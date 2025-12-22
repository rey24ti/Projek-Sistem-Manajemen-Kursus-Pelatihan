@extends('layouts.user_type.guest')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Detail Kursus</h6>
          <a href="{{ route('courses.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        @if($course->image)
        <div class="mb-3">
          <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
        </div>
        @endif
        
        <h4>{{ $course->title }}</h4>
        <p class="text-muted">{{ $course->description }}</p>
        
        <div class="row mt-4">
          <div class="col-md-6">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Informasi Kursus</h6>
            <p><strong>Kategori:</strong> <span class="badge bg-gradient-primary">{{ $course->category->name }}</span></p>
            <p><strong>Trainer:</strong> {{ $course->trainer->name }}</p>
            <p><strong>Status:</strong> <span class="badge bg-gradient-{{ $course->status_badge }}">{{ ucfirst($course->status) }}</span></p>
            @if($course->passing_score)
            <p><strong>Nilai Minimum Kelulusan:</strong> {{ $course->passing_score }}%</p>
            @endif
          </div>
          <div class="col-md-6">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Jadwal & Detail</h6>
            <p><strong>Tanggal Mulai:</strong> {{ $course->start_date->format('d F Y') }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $course->end_date->format('d F Y') }}</p>
            <p><strong>Harga:</strong> <span class="text-success font-weight-bold">Rp {{ number_format($course->price, 0, ',', '.') }}</span></p>
            <p><strong>Kuota:</strong> {{ $course->enrollments()->where('status', 'approved')->count() }}/{{ $course->max_participants }} Peserta</p>
          </div>
        </div>

        @php
          $enrollment = null;
          if (auth()->check()) {
            $enrollment = $course->enrollments()->where('user_id', auth()->id())->first();
          }
        @endphp

        @if($enrollment)
          <div class="alert alert-info mt-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <strong>Status Pendaftaran:</strong> 
                <span class="badge bg-gradient-{{ $enrollment->status_badge }}">{{ ucfirst($enrollment->status) }}</span>
                @if($enrollment->payment_status)
                  | <strong>Pembayaran:</strong> 
                  <span class="badge bg-gradient-{{ $enrollment->payment_status_badge }}">{{ ucfirst($enrollment->payment_status) }}</span>
                @endif
                @if($enrollment->progress)
                  | <strong>Progres:</strong> {{ $enrollment->progress }}%
                @endif
              </div>
            </div>
          </div>

          @if($enrollment->status == 'approved')
            <div class="mt-4">
              <h6>Akses Kursus</h6>
              <div class="row">
                <div class="col-md-3 mb-2">
                  <a href="{{ route('courses.student.materials', $course) }}" class="btn btn-outline-primary w-100">
                    <i class="ni ni-book-bookmark"></i> Materi
                  </a>
                </div>
                <div class="col-md-3 mb-2">
                  <a href="{{ route('courses.student.assignments', $course) }}" class="btn btn-outline-info w-100">
                    <i class="ni ni-paper-diploma"></i> Tugas
                  </a>
                </div>
                <div class="col-md-3 mb-2">
                  <a href="{{ route('courses.student.quizzes', $course) }}" class="btn btn-outline-warning w-100">
                    <i class="ni ni-chart-bar-32"></i> Kuis
                  </a>
                </div>
                <div class="col-md-3 mb-2">
                  <a href="{{ route('enrollments.index') }}" class="btn btn-outline-success w-100">
                    <i class="ni ni-chart-bar-32"></i> Progres
                  </a>
                </div>
              </div>
            </div>

            @if($enrollment->is_passed && $enrollment->certificate_path)
              <div class="mt-3">
                <a href="{{ route('certificates.show', $enrollment) }}" class="btn btn-success" target="_blank">
                  <i class="ni ni-trophy"></i> Download Sertifikat
                </a>
              </div>
            @endif
          @elseif($enrollment->status == 'pending')
            @if($enrollment->payment_status == 'pending')
              <div class="mt-4">
                <div class="alert alert-warning">
                  <strong>Pembayaran Belum Diverifikasi</strong><br>
                  Silakan upload bukti pembayaran untuk mempercepat proses verifikasi.
                </div>
                <a href="{{ route('payments.create', $enrollment) }}" class="btn btn-primary">
                  <i class="ni ni-cloud-upload-96"></i> Upload Bukti Pembayaran
                </a>
              </div>
            @else
              <div class="alert alert-info mt-4">
                Pendaftaran Anda sedang menunggu persetujuan dari admin.
              </div>
            @endif
          @endif
        @else
          @if($course->status == 'open' && ($course->enrollments()->where('status', 'approved')->count() < $course->max_participants))
            @auth
              <form action="{{ route('enrollments.register') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="ni ni-single-02"></i> Daftar Sekarang
                </button>
              </form>
            @else
              <div class="alert alert-warning mt-4">
                <strong>Silakan login untuk mendaftar</strong><br>
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm mt-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm mt-2">Daftar Akun</a>
              </div>
            @endauth
          @else
            <div class="alert alert-secondary mt-4">
              @if($course->status != 'open')
                Kursus ini tidak sedang membuka pendaftaran.
              @else
                Kursus sudah penuh.
              @endif
            </div>
          @endif
        @endif

        @if($course->materials->count() > 0 || $course->assignments->count() > 0 || $course->quizzes->count() > 0)
        <div class="mt-4">
          <h6>Isi Kursus</h6>
          <div class="row">
            @if($course->materials->count() > 0)
            <div class="col-md-4 mb-2">
              <div class="card">
                <div class="card-body text-center">
                  <i class="ni ni-book-bookmark text-primary" style="font-size: 2rem;"></i>
                  <h6 class="mt-2">{{ $course->materials->count() }} Materi</h6>
                </div>
              </div>
            </div>
            @endif
            @if($course->assignments->count() > 0)
            <div class="col-md-4 mb-2">
              <div class="card">
                <div class="card-body text-center">
                  <i class="ni ni-paper-diploma text-info" style="font-size: 2rem;"></i>
                  <h6 class="mt-2">{{ $course->assignments->count() }} Tugas</h6>
                </div>
              </div>
            </div>
            @endif
            @if($course->quizzes->count() > 0)
            <div class="col-md-4 mb-2">
              <div class="card">
                <div class="card-body text-center">
                  <i class="ni ni-chart-bar-32 text-warning" style="font-size: 2rem;"></i>
                  <h6 class="mt-2">{{ $course->quizzes->count() }} Kuis</h6>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
