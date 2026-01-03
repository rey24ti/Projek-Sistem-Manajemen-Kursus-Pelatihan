@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Edit Pengguna</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control @error('role') is-invalid @enderror" required>
              <option value="">Pilih Role</option>
              <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Instruktur</option>
              <option value="guest" {{ old('role', $user->role) == 'guest' ? 'selected' : '' }}>Peserta</option>
            </select>
            @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="d-flex justify-content-end">
            <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection


