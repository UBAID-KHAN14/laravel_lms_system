@extends('adminlte::page')

@section('title', 'Create FAQ')

@section('content_header')
  <h1>Add Course FAQ</h1>
@endsection

@section('content')
  <form action="{{ route('teacher.course_faqs.store') }}" method="POST">
    @csrf

    <div class="row">

      <!-- LEFT -->
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-body">

            <!-- Course -->
            <div class="form-group">
              <label>Select Course</label>
              <select name="course_id" class="form-control" required>
                <option value="">Select Course</option>
                @foreach ($courses as $course)
                  <option value="{{ $course->id }}">
                    {{ $course->title }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Question -->
            <div class="form-group">
              <label>Question</label>
              <input type="text" name="question" class="form-control" placeholder="Enter FAQ question" required>
            </div>

            <!-- Answer -->
            <div class="form-group">
              <label>Answer</label>
              <textarea name="answer" class="form-control" rows="4" placeholder="Enter FAQ answer" required></textarea>
            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-md-4">
        <div class="card card-secondary">
          <div class="card-body">
            <p class="text-muted">
              FAQs help students understand the course better before enrolling.
            </p>
            <p class="text-muted">
              Keep questions clear and answers short.
            </p>
          </div>
        </div>
      </div>

    </div>

    <div class="mt-3 text-right">
      <button class="btn btn-success">
        <i class="fas fa-save"></i> Save FAQ
      </button>
    </div>
  </form>
@endsection
