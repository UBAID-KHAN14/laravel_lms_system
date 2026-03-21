@extends('adminlte::page')

@section('title', 'Create Lecture')

@push('css')
  <style>
    .ck-editor__editable {
      min-height: 220px;
      border-radius: 0 0 .25rem .25rem;
    }
  </style>
@endpush

@section('content_header')
  <h1>Create Lecture</h1>
@endsection

@section('content')
  <form action="{{ route('teacher.course_lectures.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-body">

            <!-- SECTION -->
            <div class="form-group">
              <label>Course Section</label>
              <select name="section_id" class="form-control" required>
                <option value="">Select Section</option>
                @foreach ($courseSections as $section)
                  <option value="{{ $section->id }}">
                    {{ $section->course->title }} → {{ $section->title }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- TITLE -->
            <div class="form-group">
              <label>Lecture Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>

            <!-- DESCRIPTION -->
            <div class="form-group">
              <label>Description</label>
              <textarea name="description" class="form-control editor"></textarea>
            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="col-md-4">
        <div class="card card-secondary">
          <div class="card-body">

            <!-- VIDEO URL -->
            <div class="form-group">
              <label>Video URL (Optional)</label>
              <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/...">
            </div>

            <hr>

            <!-- VIDEO FILE -->
            <div class="form-group">
              <label>Upload Video File (Optional)</label>
              <input type="file" name="video_file" class="form-control" accept="video/*">
            </div>

            <small class="text-muted">
              Provide either Video URL or Upload Video File
            </small>

          </div>
        </div>
      </div>
    </div>

    <div class="mt-3 text-right">
      <button class="btn btn-success">
        <i class="fas fa-save"></i> Create Lecture
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
