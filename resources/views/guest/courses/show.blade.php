@extends('layouts.user_type.guest')

@section('content')
<div class="container-fluid px-2 px-md-4">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-0 pb-2 pt-3">
          <h5 class="mb-0" style="font-weight:600;font-size:1.2rem;">Detail Kursus</h5>
          <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary btn-sm px-3">Kembali</a>
        </div>
        <div class="card-body pt-2 pb-3 px-2">
        @if($course->image)
        <div class="mb-3">

          <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="img-fluid" style="max-height: 300px;">
        </div>
        @endif
        <h4 class="fw-bold mb-1" style="font-size:1.3rem;">{{ $course->title }}</h4>
        <p class="text-muted mb-2">{{ $course->description }}</p>
        <div class="row mt-3 mb-2">
          <div class="col-md-6">
            <div class="mb-1"><span class="fw-semibold">Kategori:</span> <span class="badge bg-gradient-primary">{{ $course->category->name }}</span></div>
            <div class="mb-1"><span class="fw-semibold">Trainer:</span> {{ $course->trainer->name }}</div>
            <div class="mb-1"><span class="fw-semibold">Status:</span> <span class="badge bg-gradient-{{ $course->status_badge }}">{{ ucfirst($course->status) }}</span></div>
          </div>
          <div class="col-md-6">
            <div class="mb-1"><span class="fw-semibold">Tanggal Mulai:</span> {{ $course->start_date->format('d M Y') }}</div>
            <div class="mb-1"><span class="fw-semibold">Tanggal Selesai:</span> {{ $course->end_date->format('d M Y') }}</div>
            <div class="mb-1"><span class="fw-semibold">Harga:</span> <span class="text-success fw-bold">Rp {{ number_format($course->price, 0, ',', '.') }}</span></div>
            <div class="mb-1"><span class="fw-semibold">Peserta:</span> {{ $course->enrollments()->where('status', 'approved')->count() }}/{{ $course->max_participants }}</div>
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
                <!-- Tugas dihilangkan -->
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

        @if($course->materials->count() > 0 || $course->quizzes->count() > 0)
        <div class="mt-4">
          <h6>Isi Kursus</h6>
          <div class="row">
            @if($course->materials->count() > 0)
            <div class="col-md-6 mb-2">
              <div class="card">
                <div class="card-body text-center">
                  <i class="ni ni-book-bookmark text-primary" style="font-size: 2rem;"></i>
                  <h6 class="mt-2">{{ $course->materials->count() }} Materi</h6>
                </div>
              </div>
            </div>
            @endif
            @if($course->quizzes->count() > 0)
            <div class="col-md-6 mb-2">
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




