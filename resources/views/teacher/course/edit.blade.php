@extends('adminlte::page')

@section('title', 'Create Course')

@push('css')
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

    .ck-editor__editable {
      min-height: 250px;
      border-radius: 0 0 .25rem .25rem;
    }

    .ck.ck-editor__main>.ck-editor__editable {
      border-color: #ced4da;
    }

    .section-card {
      border-top: 3px solid #007bff;
    }

    .section-title {
      font-size: 15px;
      font-weight: 600;
    }
  </style>
@endpush

@section('content_header')
  <h1>Create Course</h1>
@endsection

@section('content')
  <form action="{{ route('teacher.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
      <!-- LEFT SIDE -->
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-body">

            <div class="form-group">
              <label>Course Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', $course->title) }}">
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea name="description" rows="6" class="form-control editor">{{ old('description', $course->description) }}</textarea>

            </div>

            <div class="row">
              <div class="col-md-6">
                <label>Category</label>
                <select name="category_id" class="form-control">
                  @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $course->category_id) == $cat->id)>
                      {{ $cat->name }}
                    </option>
                  @endforeach
                </select>

              </div>

              <div class="col-md-6">
                <label>Sub Category</label>
                <select name="sub_category_id" class="form-control">
                  @foreach ($sub_categories as $subcat)
                    <option value="{{ $subcat->id }}" @selected(old('sub_category_id', $course->sub_category_id) == $subcat->id)>
                      {{ $subcat->name }}
                    </option>
                  @endforeach
                </select>

              </div>
            </div>

            <div class="form-group mt-3">
              <label>Level</label>
              <select name="level" class="form-control">
                <option value="beginner" @selected($course->level === 'beginner')>Beginner</option>
                <option value="intermediate" @selected($course->level === 'intermediate')>Intermediate</option>
                <option value="advanced" @selected($course->level === 'advanced')>Advanced</option>
              </select>

            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="col-md-4">
        <div class="card card-secondary">
          <div class="card-body">

            <label>Course Thumbnail</label>
            <div class="thumbnail-preview" style="background-image:url('{{ asset('storage/' . $course->thumbnail) }}')"
              onclick="document.getElementById('thumbnail').click()">
            </div>

            <input type="file" name="thumbnail" id="thumbnail" class="d-none" accept="image/*">

            <div class="form-group mt-3">
              <label>Price (Leave empty for Free)</label>
              <input type="number" name="price" class="form-control" value="{{ old('price', $course->price) }}">

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="text-right">
      <button class="btn btn-primary">Update Course</button>

    </div>

  </form>
@endsection

@push('js')
  <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
  <script>
    let editors = [];

    function initEditors() {
      document.querySelectorAll('.editor').forEach((el) => {
        if (!el.classList.contains('ck-editor-loaded')) {
          ClassicEditor
            .create(el)
            .then(editor => {
              editors.push(editor);
              el.classList.add('ck-editor-loaded');
            })
            .catch(error => console.error(error));
        }
      });
    }

    initEditors();
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
