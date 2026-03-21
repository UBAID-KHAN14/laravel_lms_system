@push('css')
  <style>
    .thumbnail-preview {
      width: 100%;
      height: 200px;
      background-size: cover;
      background-position: center;
      border-radius: 6px;
      cursor: pointer;
      border: 1px dashed #ccc;
    }
  </style>
@endpush
@section('page-title')
  <h1>Edit Course</h1>
@endsection
<form action="{{ route('teacher.courses.update.basic', $course->id) }}" method="POST" enctype="multipart/form-data">
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

          <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control">
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id === $course->category_id ? 'selected' : '' }}>
                  {{ $category->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Sub Category</label>
            <select name="sub_category_id" class="form-control">
              @foreach ($sub_categories as $subCategory)
                <option value="{{ $subCategory->id }}"
                  {{ $subCategory->id === $course->sub_category_id ? 'selected' : '' }}>
                  {{ $subCategory->name }}</option>
              @endforeach
            </select>
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



        </div>
      </div>
    </div>
  </div>

  <div class="text-right">
    <button class="btn btn-primary">Update Course</button>

  </div>

</form>

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const input = document.getElementById('thumbnail');
      const preview = document.querySelector('.thumbnail-preview');

      if (!input || !preview) return;

      input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          preview.style.backgroundImage = `url(${URL.createObjectURL(file)})`;
          preview.innerHTML = '';
        }
      });
    });
  </script>
@endpush
