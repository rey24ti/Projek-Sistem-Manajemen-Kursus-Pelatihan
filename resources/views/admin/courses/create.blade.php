@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Tambah Kursus</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Judul Kursus</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Kategori</label>
              <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
              </select>
              @error('category_id')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Trainer</label>
              <select name="trainer_id" class="form-control @error('trainer_id') is-invalid @enderror" required>
                <option value="">Pilih Trainer</option>
                @foreach($trainers as $trainer)
                <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>{{ $trainer->name }}</option>
                @endforeach
              </select>
              @error('trainer_id')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Mulai</label>
              <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
              @error('start_date')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Selesai</label>
              <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
              @error('end_date')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Maksimal Peserta</label>
              <input type="number" name="max_participants" class="form-control @error('max_participants') is-invalid @enderror" value="{{ old('max_participants', 0) }}" min="1" required>
              @error('max_participants')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
              @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Harga</label>
              <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 0) }}" min="0" step="0.01" required>
              @error('price')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
<<<<<<< HEAD
=======
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nilai Minimum Kelulusan (0-100)</label>
              <input type="number" name="passing_score" class="form-control @error('passing_score') is-invalid @enderror" value="{{ old('passing_score', 70) }}" min="0" max="100" required>
              <small class="text-muted">Nilai minimum yang harus dicapai peserta untuk lulus kursus</small>
              @error('passing_score')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
>>>>>>> eb0562031114ae97354f05b2289eed62aa7a791f
          <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="d-flex justify-content-end">
            <a href="{{ route('courses.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

