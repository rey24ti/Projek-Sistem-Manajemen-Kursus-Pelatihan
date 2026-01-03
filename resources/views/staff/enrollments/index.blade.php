@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Peserta Kursus</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <form method="GET" action="{{ route('enrollments.index') }}" class="p-3">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="search" class="form-control" placeholder="Cari peserta atau kursus..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
              <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
          </div>
        </form>
        <div class="row p-3">
          @forelse($enrollments as $enrollment)
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title mb-0">{{ $enrollment->user->name }}</h5>
                <p class="card-text text-sm text-secondary">{{ $enrollment->user->email }}</p>

                <p class="text-xs text-secondary mb-2">
                  <strong>Kursus:</strong> {{ $enrollment->course->title }}<br>
                  <strong>Status:</strong> <span class="badge badge-sm bg-gradient-{{ $enrollment->status_badge }}">{{ ucfirst($enrollment->status) }}</span>
                </p>

                <div class="progress-wrapper">
                  <div class="progress-info">
                    <div class="progress-percentage">
                      <span class="text-xs font-weight-bold"><?php echo (int)($enrollment->progress ?? 0); ?>%</span>
                    </div>
                  </div>
                  <div class="progress">
                    <div class="progress-bar bg-gradient-info" style="width: <?php echo (int)($enrollment->progress ?? 0); ?>%"></div>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <form action="{{ route('enrollments.update', $enrollment) }}" method="POST" class="d-flex align-items-center flex-wrap gap-2">
                  @csrf
                  @method('PUT')
                  <select name="status" class="form-control form-control-sm" style="width: auto;" onchange="this.form.submit()">
                    <option value="pending" {{ $enrollment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $enrollment->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $enrollment->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="completed" {{ $enrollment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                  </select>
                  <input type="number" name="progress" class="form-control form-control-sm" style="width: 110px;" value="{{ $enrollment->progress }}" min="0" max="100" placeholder="Progress %">
                </form>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12">
            <p class="text-center">Tidak ada peserta</p>
          </div>
          @endforelse
        </div>
        <div class="px-3 py-2">
          {{ $enrollments->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

