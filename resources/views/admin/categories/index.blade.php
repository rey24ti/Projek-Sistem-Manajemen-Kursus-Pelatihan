@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Daftar Kategori</h6>
          <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Kursus</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $category)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $category->name }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ Str::limit($category->description, 50) }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $category->courses_count }}</span>
                </td>
                <td class="align-middle">
                  <a href="{{ route('categories.edit', $category) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                    Edit
                  </a>
                  <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent ms-2" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center">Tidak ada kategori</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          {{ $categories->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

