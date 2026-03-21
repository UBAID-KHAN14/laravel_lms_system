@extends('adminlte::page')

@section('title', 'Upload Lecture Material')

@section('content_header')
  <h1>Upload Lecture Material</h1>
@endsection

@section('content')
  <form action="{{ route('teacher.course_lecture_materials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">

      <!-- LEFT -->
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-body">

            <!-- Lecture -->
            <div class="form-group">
              <label>Select Lecture</label>
              <select name="lecture_id" class="form-control" required>
                <option value="">Select Lecture</option>
                @foreach ($lectures as $lecture)
                  <option value="{{ $lecture->id }}">
                    {{ $lecture->section->course->title }}
                    → {{ $lecture->section->title }}
                    → {{ $lecture->title }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- File Upload -->
            <div class="form-group">
              <label>Upload File</label>
              <input type="file" name="file_name" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
              <small class="text-muted">
                PDF, DOC, DOCX, PPT, PPTX allowed
              </small>
            </div>



          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-md-4">
        <div class="card card-secondary">
          <div class="card-body">
            <p class="text-muted">
              File path and file type will be automatically detected and stored.
            </p>
          </div>
        </div>
      </div>

    </div>

    <div class="mt-3 text-right">
      <button class="btn btn-success">
        <i class="fas fa-upload"></i> Upload Material
      </button>
    </div>

  </form>
@endsection
