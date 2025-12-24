@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Daftar Kursus Tersedia</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <form method="GET" action="{{ route('courses.index') }}" class="p-3">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="search" class="form-control" placeholder="Cari kursus..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
              <select name="category_id" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Category::all() as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
          </div>
        </form>
        <div class="row p-3">
          @forelse($courses as $course)
          <div class="col-md-6 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{ $course->title }}</h5>
                <p class="card-text">{{ Str::limit($course->description, 150) }}</p>
                <div class="mb-3">
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
                <div class="d-flex justify-content-between align-items-center">
                  <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary">Detail</a>
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
                      <button type="submit" class="btn btn-sm btn-primary">Daftar Sekarang</button>
                    </form>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12">
            <p class="text-center">Tidak ada kursus tersedia</p>
          </div>
          @endforelse
        </div>
        <div class="px-3 py-2">
          {{ $courses->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
