@extends('layouts.user_type.auth')

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
          <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="img-fluid" style="max-height: 300px;">
        </div>
        @endif
        <h4>{{ $course->title }}</h4>
        <p class="text-muted">{{ $course->description }}</p>
        <div class="row mt-4">
          <div class="col-md-6">
            <p><strong>Kategori:</strong> {{ $course->category->name }}</p>
            <p><strong>Status:</strong> <span class="badge bg-gradient-{{ $course->status_badge }}">{{ ucfirst($course->status) }}</span></p>
          </div>
          <div class="col-md-6">
            <p><strong>Tanggal Mulai:</strong> {{ $course->start_date->format('d M Y') }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $course->end_date->format('d M Y') }}</p>
            <p><strong>Peserta:</strong> {{ $course->enrollments()->where('status', 'approved')->count() }}/{{ $course->max_participants }}</p>
          </div>
        </div>
        <div class="mt-4">
          <a href="{{ route('materials.index', $course) }}" class="btn btn-info">Kelola Materi</a>
          <a href="{{ route('enrollments.index', ['course_id' => $course->id]) }}" class="btn btn-success">Lihat Peserta</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

