@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Tambah Kuis: {{ $course->title }}</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('courses.quizzes.store', $course) }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label">Judul Kuis</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Pertanyaan (JSON)</label>
            <textarea name="questions" class="form-control @error('questions') is-invalid @enderror" rows="8" placeholder='[{"question":"...","options":["A","B"],"correct_answer":"A"}]'>{{ old('questions') }}</textarea>
            @error('questions')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Format: array of questions. Field minimal: question, options, correct_answer.</small>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Time Limit (menit)</label>
              <input type="number" name="time_limit" class="form-control @error('time_limit') is-invalid @enderror" value="{{ old('time_limit') }}" min="1">
              @error('time_limit')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label">Passing Score (%)</label>
              <input type="number" name="passing_score" class="form-control @error('passing_score') is-invalid @enderror" value="{{ old('passing_score', 70) }}" min="0" max="100" required>
              @error('passing_score')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label">Urutan</label>
              <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" min="0">
              @error('order')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Mulai</label>
              <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
              @error('start_date')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Selesai</label>
              <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
              @error('end_date')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <a href="{{ route('courses.quizzes.index', $course) }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
