@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Daftar Kursus</h6>
          <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">Tambah Kursus</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <form method="GET" action="{{ route('courses.index') }}" class="p-3">
            <div class="row">
              <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari kursus..." value="{{ request('search') }}">
              </div>
              <div class="col-md-3">
                <select name="category_id" class="form-control">
                  <option value="">Semua Kategori</option>
                  @foreach(\App\Models\Category::all() as $cat)
                  <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <select name="status" class="form-control">
                  <option value="">Semua Status</option>
                  <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                  <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                  <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                  <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                  <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
              </div>
            </div>
          </form>
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kursus</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trainer</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              @forelse($courses as $course)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $course->title }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ Str::limit($course->description, 50) }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $course->category->name }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <p class="text-xs font-weight-bold mb-0">{{ $course->trainer->name }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-{{ $course->status_badge }}">{{ ucfirst($course->status) }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $course->enrollments()->where('status', 'approved')->count() }}/{{ $course->max_participants }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                </td>
                <td class="align-middle">
                  <a href="{{ route('courses.show', $course) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Lihat">
                    Lihat
                  </a>
                  <a href="{{ route('courses.edit', $course) }}" class="text-secondary font-weight-bold text-xs ms-2" data-toggle="tooltip" data-original-title="Edit">
                    Edit
                  </a>
                  <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">Tidak ada kursus</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          {{ $courses->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

