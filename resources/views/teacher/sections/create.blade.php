@extends('adminlte::page')

@section('title', 'Create Sections Page')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')
  @include('messages.success')
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert"
      style="background-color: #DC3545;color: white;">
      <strong>Please fix the following errors:</strong>
      <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">
        <i class="fas fa-file-alt mr-1"></i> Create Sections Page
      </h3>

      <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-sm btn-success" onclick="addSection()">
          <i class="fas fa-plus"></i> Add Section
        </button>

        <a href="{{ route('admin.term_privacy.index') }}" class="btn btn-sm btn-outline-secondary">
          <i class="fas fa-arrow-left"></i> Back
        </a>
      </div>
    </div>


    <form action="{{ route('teacher.course_sections.store') }}" method="POST">
      @csrf

      <div class="card-body" id="sectionsContainer">
        <!-- Sections will be injected here -->
      </div>


      <div class="card-footer text-right">
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-save"></i> Save Sections
        </button>
      </div>
    </form>
  </div>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

  <script>
    let sectionIndex = 0;

    function addSection() {
      sectionIndex++;

      const html = `
        <div class="card section-card mb-4" id="section-${sectionIndex}">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <span class="section-title">
                    <i class="fas fa-layer-group mr-1"></i> Section ${sectionIndex}
                </span>

                <button type="button"
                        class="btn btn-xs btn-danger"
                        onclick="removeSection(${sectionIndex})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label>Course Id</label>
                     <select name="sections[${sectionIndex}][course_id]" class="form-control">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
               


                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text"
                           name="sections[${sectionIndex}][title]"
                           class="form-control"
                           placeholder="Enter section title"
                           >
                </div>

                <div class="form-group">
                    <label>Section Order</label>
                    <input type="number"
                           name="sections[${sectionIndex}][order_number]"
                           class="form-control"
                           placeholder="Enter section order"
                           >
                </div>


            </div>
        </div>
        `;

      document.getElementById('sectionsContainer')
        .insertAdjacentHTML('beforeend', html);

      initEditors();
    }

    function removeSection(id) {
      const section = document.getElementById(`section-${id}`);
      if (section) section.remove();
    }

    // Auto add first section
    addSection();
  </script>
@endpush
