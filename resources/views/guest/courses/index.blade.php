@extends('layouts.user_type.guest')

@section('content')

<div class="container-fluid px-2 px-md-4">
  <div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 pb-2 pt-3">
          <h5 class="mb-0" style="font-weight:600;font-size:1.2rem;">Daftar Kursus Tersedia</h5>
        </div>
        <div class="card-body pt-2 pb-3 px-2">
          <form method="GET" action="{{ route('courses.index') }}" class="mb-3">
            <div class="row g-2 align-items-center">
              <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kursus..." value="{{ request('search') }}">
              </div>
              <div class="col-md-4">
                <select name="category_id" class="form-select form-select-sm">
                  <option value="">Semua Kategori</option>
                  @foreach(\App\Models\Category::all() as $cat)
                  <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100" style="margin-top: 14px;">Cari</button>
              </div>
            </div>
          </form>
          <div class="row g-3">
            @forelse($courses as $course)
            <div class="col-md-6 col-lg-4">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body pb-2">
                  <h6 class="fw-bold mb-1" style="font-size:1.1rem;">{{ $course->title }}</h6>
                  <div class="mb-2 text-muted small">{{ Str::limit($course->description, 90) }}</div>
                  <div class="mb-2">
                    <span class="badge bg-gradient-primary">{{ $course->category->name }}</span>
                    <span class="badge bg-gradient-success">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                    <span class="badge bg-gradient-info">{{ $course->enrollments()->where('status', 'approved')->count() }}/{{ $course->max_participants }} Peserta</span>
                  </div>
                  <div class="mb-2">
                    <small class="text-muted">
                      <i class="ni ni-calendar-grid-58"></i> {{ $course->start_date->format('d M Y') }} - {{ $course->end_date->format('d M Y') }}
                    </small><br>
                    <small class="text-muted">
                      <i class="ni ni-single-02"></i> Trainer: {{ $course->trainer->name }}
                    </small>
                  </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0 pb-3 px-3 d-flex justify-content-between align-items-center">
                  <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-primary btn-sm px-3">Detail</a>
                  @php
                    $isEnrolled = \App\Models\Enrollment::where('user_id', auth()->id())
                      ->where('course_id', $course->id)
                      ->exists();
                  @endphp
                  @if($isEnrolled)
                    <span class="badge bg-gradient-success">Sudah Terdaftar</span>
                  @else
                    <form action="{{ route('enrollments.register') }}" method="POST" class="d-inline">
                      @csrf
                      <input type="hidden" name="course_id" value="{{ $course->id }}">
                      <button type="submit" class="btn btn-primary btn-sm">Daftar</button>
                    </form>
                  @endif
                </div>
              </div>
            </div>
            @empty
            <div class="col-12">
              <p class="text-center text-muted">Tidak ada kursus tersedia</p>
            </div>
            @endforelse
          </div>
          <div class="pt-3">
            {{ $courses->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

