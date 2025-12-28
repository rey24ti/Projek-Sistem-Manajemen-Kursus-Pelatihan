@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Upload Bukti Pembayaran</h6>
      </div>
      <div class="card-body">
        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('payments.store', $enrollment) }}" method="POST" enctype="multipart/form-data">
          @csrf

          <p class="text-sm text-muted"><strong>Kursus:</strong> {{ $course->title }}</p>
          <p class="text-sm text-muted"><strong>Harga:</strong> Rp {{ number_format($course->price, 0, ',', '.') }}</p>

          @unless(auth()->check())
          <div class="mb-3">
            <label class="form-label">Email Pendaftar</label>
            <input type="email" name="owner_email" value="{{ old('owner_email') }}" class="form-control" required>
            <small class="text-muted">Masukkan email yang digunakan saat mendaftar</small>
          </div>
          @endunless

          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="payment_method" class="form-control" required>
              <option value="transfer">Transfer</option>
              <option value="cash">Cash</option>
              <option value="other">Lainnya</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Bukti (foto/scan)</label>
            <input type="file" name="proof" class="form-control" accept="image/*" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
          </div>

          <div class="mb-3 d-flex gap-2">
            <button class="btn btn-primary" type="submit">Upload</button>
            <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
