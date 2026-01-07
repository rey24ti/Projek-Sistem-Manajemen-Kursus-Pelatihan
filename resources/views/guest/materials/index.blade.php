@extends('layouts.user_type.guest')

@section('content')

<div class="container-fluid px-2 px-md-4">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-0 pb-2 pt-3">
          <h5 class="mb-0" style="font-weight:600;font-size:1.2rem;">Materi Kursus: <span class="text-primary">{{ $course->title }}</span></h5>
          <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-secondary btn-sm px-3">Kembali</a>
        </div>
        <div class="card-body pt-2 pb-3 px-2">
          <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
              <thead class="bg-light">
                <tr>
                  <th style="width:35%">Judul</th>
                  <th style="width:45%">Deskripsi</th>
                  <th class="text-center" style="width:10%">File</th>
                  <th class="text-center" style="width:10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($materials as $material)
                <tr>
                  <td class="fw-semibold">{{ $material->title }}</td>
                  <td class="text-muted small">{{ Str::limit($material->description, 70) }}</td>
                  <td class="text-center small">{{ $material->file_name }}</td>
                  <td class="text-center">
                    <a href="{{ route('materials.download', $material) }}" class="btn btn-info btn-sm px-3" style="font-weight:600;">Download</a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center text-muted">Tidak ada materi</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
