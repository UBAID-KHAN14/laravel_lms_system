@extends('adminlte::page')

@section('title', 'Create Course')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

  <style>
    .thumbnail-preview {
      width: 100%;
      height: 220px;
      border: 2px dashed #ddd;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      background-size: cover;
      background-position: center;
    }
  </style>
@endpush

@section('content_header')
  <h1>Create Course</h1>
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Please fix the following errors:</strong>
      <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
      <!-- LEFT SIDE -->
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-body">

            <div class="form-group">
              <label>Course Title</label>
              <input type="text" name="title" value="{{ old('title') }}"
                class="form-control @error('title') is-invalid @enderror">
              @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea name="description" rows="6" class="form-control editor @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

            </div>

            <div class="row">
              <div class="col-md-6">
                <label>Category</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                  <option value="">Select Category</option>
                  @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                      {{ $cat->name }}
                    </option>
                  @endforeach
                </select>

                @error('category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror

              </div>

              <div class="col-md-6">
                <label>Sub Category</label>
                <select name="sub_category_id" class="form-control @error('sub_category_id') is-invalid @enderror">
                  <option value="">Select Sub Category</option>
                  @foreach ($sub_categories as $subcat)
                    <option value="{{ $subcat->id }}" {{ old('sub_category_id') == $subcat->id ? 'selected' : '' }}>
                      {{ $subcat->name }}
                    </option>
                  @endforeach
                </select>

                @error('sub_category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror

              </div>
            </div>

            <div class="form-group mt-3">
              <label>Level</label>
              <select name="level" class="form-control @error('level') is-invalid @enderror">
                <option value="">Select Level</option>
                <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>
                  Beginner
                </option>
                <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>
                  Intermediate
                </option>
                <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>
                  Advanced
                </option>
              </select>

              @error('level')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="col-md-4">
        <div class="card card-secondary">
          <div class="card-body">

            <label>Course Thumbnail</label>
            <div class="thumbnail-preview" onclick="document.getElementById('thumbnail').click()">
              <span>Click to upload image</span>
            </div>
            <input type="file" name="thumbnail" id="thumbnail" class="d-none @error('thumbnail') is-invalid @enderror"
              accept="image/*">
            @error('thumbnail')
              <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <div class="text-right">
      <button class="btn btn-dark" onclick="this.disabled=true;this.innerText='Saving...';this.form.submit();">Create &
        Continue</button>
    </div>

  </form>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
  <script>
    $(document).ready(function() {
      // Initialize Summernote editors
      $('.editor').summernote({
        height: 250,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    });

    document.getElementById('thumbnail').addEventListener('change', function(e) {
      const preview = document.querySelector('.thumbnail-preview');
      const file = e.target.files[0];
      if (file) {
        preview.style.backgroundImage = `url(${URL.createObjectURL(file)})`;
        preview.innerHTML = '';
      }
    });
  </script>
@endpush
