@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Edit Materi: {{ $material->course->title }}</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('materials.update', $material) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label">Judul Materi</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $material->title) }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $material->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">File (kosongkan jika tidak ingin mengubah)</label>
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
            @error('file')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">File saat ini: {{ $material->file_name }}</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $material->order) }}" min="0">
            @error('order')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="d-flex justify-content-end">
            <a href="{{ route('materials.index', $material->course) }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

