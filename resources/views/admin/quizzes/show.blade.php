@extends('layouts.user_type.auth')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Detail Kuis: {{ $quiz->title }}</h6>
          <div>
            <a href="{{ route('courses.quizzes.edit', [$course, $quiz]) }}" class="btn btn-secondary btn-sm">Edit</a>
            <a href="{{ route('courses.quizzes.index', $course) }}" class="btn btn-primary btn-sm">Kembali</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <p class="text-sm mb-2"><strong>Deskripsi:</strong> {{ $quiz->description ?? '-' }}</p>
            <p class="text-sm mb-2"><strong>Jumlah Soal:</strong> {{ is_array($quiz->questions) ? count($quiz->questions) : 0 }}</p>
          </div>
          <div class="col-md-4">
            <p class="text-sm mb-2"><strong>Passing Score:</strong> {{ $quiz->passing_score }}%</p>
            <p class="text-sm mb-2"><strong>Time Limit:</strong> {{ $quiz->time_limit ? $quiz->time_limit.' menit' : '-' }}</p>
            <p class="text-sm mb-2"><strong>Jadwal:</strong><br>
              {{ $quiz->start_date?->format('d M Y H:i') }} - {{ $quiz->end_date?->format('d M Y H:i') }}
            </p>
          </div>
        </div>

        <hr>

        <h6 class="mb-3">Daftar Pengumpulan</h6>
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peserta</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nilai</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              @forelse($quiz->submissions as $submission)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $submission->user?->name ?? '-' }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $submission->user?->email ?? '-' }}</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $submission->status ?? '-' }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $submission->score !== null ? number_format((float)$submission->score, 2) : '-' }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $submission->submitted_at?->format('d M Y H:i') ?? '-' }}</span>
                </td>
                <td class="align-middle">
                  <form action="{{ route('submissions.grade-quiz', [$course, $quiz, $submission]) }}" method="POST" class="d-flex flex-wrap gap-2">
                    @csrf
                    <input type="number" name="score" class="form-control form-control-sm" style="width: 110px;" min="0" max="100" step="0.01" value="{{ old('score', $submission->score) }}" placeholder="Nilai">
                    <input type="text" name="feedback" class="form-control form-control-sm" style="width: 220px;" value="{{ old('feedback', $submission->feedback) }}" placeholder="Feedback">
                    <button type="submit" class="btn btn-sm btn-primary">Nilai</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">Belum ada pengumpulan</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
