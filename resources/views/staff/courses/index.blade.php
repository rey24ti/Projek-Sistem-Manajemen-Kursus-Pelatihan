@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Kursus Saya</h6>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <form method="GET" action="{{ route('courses.index') }}" class="p-3">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="search" class="form-control" placeholder="Cari kursus..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
              <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
              </select>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
          </div>
        </form>
        <div class="row p-3">
          @forelse($courses as $course)
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              @if($course->image)
              <img src="{{ Storage::url($course->image) }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
              @endif
              <div class="card-body">
                <h5 class="card-title">{{ $course->title }}</h5>
                <p class="card-text text-sm">{{ Str::limit($course->description, 100) }}</p>
                <p class="text-xs text-secondary mb-2">
                  <strong>Kategori:</strong> {{ $course->category->name }}<br>
                  <strong>Status:</strong> <span class="badge badge-sm bg-gradient-{{ $course->status_badge }}">{{ ucfirst($course->status) }}</span><br>
                  <strong>Peserta:</strong> {{ $course->enrollments()->where('status', 'approved')->count() }}/{{ $course->max_participants }}
                </p>
              </div>
              <div class="card-footer">
                <div class="d-flex justify-content-between">
                  <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-primary">Detail</a>
                  <a href="{{ route('materials.index', $course) }}" class="btn btn-sm btn-info">Materi</a>
                  <a href="{{ route('enrollments.index', ['course_id' => $course->id]) }}" class="btn btn-sm btn-success">Peserta</a>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12">
            <p class="text-center">Tidak ada kursus</p>
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

