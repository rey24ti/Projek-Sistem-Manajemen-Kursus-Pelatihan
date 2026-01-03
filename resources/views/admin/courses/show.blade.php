@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Detail Kursus</h6>
          <div>
            @if($course->status === 'pending')
            <form action="{{ route('courses.approve', $course) }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve kursus ini dan buka pendaftaran?')">Approve</button>
            </form>
            @endif
            <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('courses.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          @if($course->image)
          <div class="col-lg-5 mb-4 mb-lg-0">
            <div style="height: 320px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 0.75rem;">
              <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="img-fluid" style="max-height: 100%; max-width: 100%; width: auto; height: auto;">
            </div>
          </div>
          @endif

          <div class="{{ $course->image ? 'col-lg-7' : 'col-12' }}">
            <h4 class="mb-1">{{ $course->title }}</h4>
            <p class="text-muted mb-3">{{ $course->description }}</p>

            <div class="row">
              <div class="col-md-6">
                <ul class="list-group">
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Kategori:</strong> {{ $course->category->name }}</li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Trainer:</strong> {{ $course->trainer->name }}</li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Status:</strong> <span class="badge bg-gradient-{{ $course->status_badge }}">{{ ucfirst($course->status) }}</span></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="list-group">
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Tanggal Mulai:</strong> {{ $course->start_date->format('d M Y') }}</li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Tanggal Selesai:</strong> {{ $course->end_date->format('d M Y') }}</li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Harga:</strong> Rp {{ number_format($course->price, 0, ',', '.') }}</li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Nilai Minimum Kelulusan:</strong> {{ $course->passing_score ?? 70 }}%</li>
                  <li class="list-group-item border-0 px-0 text-sm"><strong>Peserta:</strong> {{ $course->enrollments()->where('status', 'approved')->count() }}/{{ $course->max_participants }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-6 mb-4 mb-md-0">
            <div class="card h-100">
              <div class="card-body">
                <h6>Materi Kursus</h6>
                <a href="{{ route('materials.index', $course) }}" class="btn btn-sm btn-info">Kelola Materi</a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <h6>Peserta Terdaftar</h6>
                <a href="{{ route('enrollments.index', ['course_id' => $course->id]) }}" class="btn btn-sm btn-success">Lihat Peserta</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

