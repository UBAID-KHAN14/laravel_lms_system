@extends('adminlte::page')

@section('title', 'Edit Lecture')

@push('css')
  <style>
    .ck-editor__editable {
      min-height: 220px;
    }
  </style>
@endpush

@section('content_header')
  <h1>Edit Lecture</h1>
@endsection

@section('content')
  <form action="{{ route('teacher.course_lectures.update', $courseLecture->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
      <!-- LEFT -->
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-body">

            <!-- SECTION -->
            <div class="form-group">
              <label>Course Section</label>
              <select name="section_id" class="form-control @error('section_id') is-invalid @enderror">
                <option value="">Select Section</option>
                @foreach ($courseSections as $section)
                  <option value="{{ $section->id }}" @selected(old('section_id', $courseLecture->section_id) == $section->id)>
                    {{ $section->course->title }} → {{ $section->title }}
                  </option>
                @endforeach
              </select>
              @error('section_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- TITLE -->
            <div class="form-group">
              <label>Lecture Title</label>
              <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $courseLecture->title) }}">
              @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- DESCRIPTION -->
            <div class="form-group">
              <label>Description</label>
              <textarea name="description" class="form-control editor">{{ old('description', $courseLecture->description) }}</textarea>
            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-md-4">
        <div class="card card-secondary">
          <div class="card-body">

            <!-- VIDEO URL -->
            <div class="form-group">
              <label>Video URL</label>
              <input type="url" name="video_url" class="form-control"
                value="{{ old('video_url', $courseLecture->video_url) }}">
            </div>

            <hr>

            <!-- VIDEO FILE -->
            <div class="form-group">
              <label>Upload Video File</label>
              <input type="file" name="video_file" class="form-control" accept="video/*">
            </div>

            @if ($courseLecture->video_file)
              <video width="100%" controls class="mt-2">
                <source src="{{ asset('storage/' . $courseLecture->video_file) }}">
              </video>
            @else
              <p class="text-muted">No video file uploaded.</p>
            @endif

            <small class="text-muted d-block mt-2">
              Provide either a video URL or upload a video file
            </small>

          </div>
        </div>
      </div>
    </div>

    <div class="mt-3 text-right">
      <button class="btn btn-success">
        <i class="fas fa-save"></i> Update Lecture
      </button>
    </div>
  </form>
@endsection

@push('js')
  <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
  <script>
    document.querySelectorAll('.editor').forEach(el => {
      ClassicEditor.create(el).catch(console.error);
    });
  </script>
@endpush
