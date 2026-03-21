@extends('adminlte::page')

@section('title', 'Edit FAQ')

@section('content_header')
  <h1>Edit Course FAQ</h1>
@endsection

@section('content')
  <form action="{{ route('teacher.course_faqs.update', $faq->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">

      <!-- LEFT -->
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-body">

            <!-- Course -->
            <div class="form-group">
              <label>Select Course</label>
              <select name="course_id" class="form-control" required>
                @foreach ($courses as $course)
                  <option value="{{ $course->id }}" {{ $faq->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Question -->
            <div class="form-group">
              <label>Question</label>
              <input type="text" name="question" class="form-control" value="{{ $faq->question }}" required>
            </div>

            <!-- Answer -->
            <div class="form-group">
              <label>Answer</label>
              <textarea name="answer" class="form-control" rows="4" required>{{ $faq->answer }}</textarea>
            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-md-4">
        <div class="card card-secondary">
          <div class="card-body">
            <p class="text-muted"><strong>Course:</strong></p>
            <p>{{ $faq->course->title }}</p>
          </div>
        </div>
      </div>

    </div>

    <div class="mt-3 text-right">
      <button class="btn btn-primary">
        <i class="fas fa-save"></i> Update FAQ
      </button>
    </div>
  </form>
@endsection
