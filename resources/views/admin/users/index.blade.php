@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Daftar Pengguna</h6>
          <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Tambah Pengguna</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="px-3 mb-3">
          <form action="{{ route('users.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
              <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
              <select name="role" class="form-control">
                <option value="">Semua Role</option>
                <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Instruktur</option>
                <option value="guest" {{ request('role') == 'guest' ? 'selected' : '' }}>Peserta</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary">Cari</button>
              <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
            </div>
          </form>
        </div>
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Telepon</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  @if($user->role == 'staff')
                    <span class="badge bg-gradient-info">Instruktur</span>
                  @elseif($user->role == 'guest')
                    <span class="badge bg-gradient-success">Peserta</span>
                  @else
                    <span class="badge bg-gradient-primary">Admin</span>
                  @endif
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $user->phone ?? '-' }}</span>
                </td>
                <td class="align-middle">
                  <a href="{{ route('users.show', $user) }}" class="text-info font-weight-bold text-xs me-2" data-toggle="tooltip" data-original-title="Detail">Detail</a>
                  @if(!$user->isAdmin())
                    <a href="{{ route('users.edit', $user) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" data-original-title="Edit">Edit</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">Tidak ada pengguna</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


