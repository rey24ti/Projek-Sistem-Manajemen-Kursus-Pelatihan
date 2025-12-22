@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Daftar Pendaftaran</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <form method="GET" action="{{ route('enrollments.index') }}" class="p-3">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="search" class="form-control" placeholder="Cari peserta atau kursus..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
              <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
              </select>
            </div>
            <div class="col-md-3">
              <select name="payment_status" class="form-control">
                <option value="">Semua Status Pembayaran</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ request('payment_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="rejected" {{ request('payment_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
          </div>
        </form>
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kursus</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nilai</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kelulusan</th>
                <th class="text-secondary opacity-7">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($enrollments as $enrollment)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $enrollment->user->name }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $enrollment->user->email }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $enrollment->course->title }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-{{ $enrollment->status_badge }}">{{ ucfirst($enrollment->status) }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-{{ $enrollment->payment_status_badge }}">{{ ucfirst($enrollment->payment_status) }}</span>
                  @if($enrollment->payment_status == 'pending')
                  <div class="mt-1">
                    <button type="button" class="btn btn-xs btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $enrollment->id }}">Verify</button>
                  </div>
                  @endif
                </td>
                <td class="align-middle text-center">
                  <div class="progress-wrapper w-75 mx-auto">
                    <div class="progress-info">
                      <div class="progress-percentage">
                        <span class="text-xs font-weight-bold">{{ $enrollment->progress }}%</span>
                      </div>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-info" style="width: {{ $enrollment->progress }}%"></div>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  @if($enrollment->final_score !== null)
                    <span class="text-xs font-weight-bold">{{ number_format($enrollment->final_score, 2) }}</span>
                  @else
                    <span class="text-secondary text-xs">-</span>
                  @endif
                </td>
                <td class="align-middle text-center text-sm">
                  @if($enrollment->final_score !== null)
                    @if($enrollment->is_passed)
                      <span class="badge badge-sm bg-gradient-success">Lulus</span>
                    @else
                      <span class="badge badge-sm bg-gradient-danger">Tidak Lulus</span>
                    @endif
                  @else
                    <span class="text-secondary text-xs">-</span>
                  @endif
                </td>
                <td class="align-middle">
                  <button type="button" class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal{{ $enrollment->id }}">Edit</button>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center">Tidak ada pendaftaran</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2">
          {{ $enrollments->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Payment Verification Modal -->
@foreach($enrollments as $enrollment)
<div class="modal fade" id="paymentModal{{ $enrollment->id }}" tabindex="-1" aria-labelledby="paymentModalLabel{{ $enrollment->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel{{ $enrollment->id }}">Verifikasi Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('enrollments.verify-payment', $enrollment) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Status Pembayaran</label>
            <select name="payment_status" class="form-control" required>
              <option value="verified">Verified</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
          </div>
          <p class="text-sm text-muted"><strong>Kursus:</strong> {{ $enrollment->course->title }}</p>
          <p class="text-sm text-muted"><strong>Harga:</strong> Rp {{ number_format($enrollment->course->price, 0, ',', '.') }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Update Enrollment Modal -->
<div class="modal fade" id="updateModal{{ $enrollment->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $enrollment->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel{{ $enrollment->id }}">Update Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('enrollments.update', $enrollment) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Status Pendaftaran</label>
              <select name="status" class="form-control" required>
                <option value="pending" {{ $enrollment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $enrollment->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $enrollment->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="completed" {{ $enrollment->status == 'completed' ? 'selected' : '' }}>Completed</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Status Pembayaran</label>
              <select name="payment_status" class="form-control">
                <option value="pending" {{ $enrollment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ $enrollment->payment_status == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="rejected" {{ $enrollment->payment_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Progres (%)</label>
              <input type="number" name="progress" class="form-control" value="{{ $enrollment->progress }}" min="0" max="100" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Nilai Akhir (0-100)</label>
              <input type="number" name="final_score" class="form-control" value="{{ $enrollment->final_score }}" min="0" max="100" step="0.01">
              <small class="text-muted">Nilai minimum kelulusan: {{ $enrollment->course->passing_score ?? 70 }}%</small>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="completion_date" class="form-control" value="{{ $enrollment->completion_date ? $enrollment->completion_date->format('Y-m-d') : '' }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="3">{{ $enrollment->notes }}</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection

