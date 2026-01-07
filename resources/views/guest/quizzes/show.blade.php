@extends('layouts.user_type.guest')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Kuis: {{ $quiz->title }}</h6>
        <a href="{{ route('courses.student.quizzes', $course) }}" class="btn btn-secondary btn-sm">Kembali</a>
      </div>
      <div class="card-body">
        <p>{{ $quiz->description }}</p>
        <form action="{{ route('submissions.submit-quiz', [$course, $quiz]) }}" method="POST">
          @csrf
          @foreach($quiz->questions as $i => $q)
            <div class="mb-4">
              <label class="form-label"><strong>Pertanyaan {{ $i+1 }}:</strong> {{ $q['question'] }}</label>
              @foreach($q['options'] as $opt)
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="answers[{{ $i }}]" value="{{ $opt }}" id="q{{ $i }}_{{ $loop->index }}" required>
                  <label class="form-check-label" for="q{{ $i }}_{{ $loop->index }}">{{ $opt }}</label>
                </div>
              @endforeach
            </div>
          @endforeach
          <button type="submit" class="btn btn-primary">Kumpulkan Jawaban</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
