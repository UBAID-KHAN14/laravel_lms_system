@extends('adminlte::page')

@section('title', 'Create Page')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
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
        <i class="fas fa-file-alt mr-1"></i> Create Page
      </h3>

      {{-- // align this at end of header with some gap --}}

      <div class="d-flex align-items-center gap-2 text-right">
        <button type="button" class="btn btn-sm btn-success" onclick="addSection()">
          <i class="fas fa-plus"></i> Add Section
        </button>

        <a href="{{ route('admin.term_privacy.index') }}" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-arrow-left"></i> Back to Pages
        </a>
      </div>
    </div>


    <form action="{{ route('admin.term_privacy.store') }}" method="POST">
      @csrf

      <div class="card-body" id="sectionsContainer">
        <!-- Sections will be injected here -->
      </div>


      <div class="card-footer text-right">
        <button type="reset" class="btn btn-outline-secondary"><i class="fas fa-undo mr-1"></i> Reset</button>
        <button class="btn btn-dark" type="submit">
          <i class="fas fa-save"></i> Save Page
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
                    <label>Section Type</label>
                     <select name="sections[${sectionIndex}][type]" class="form-control">
                      <option value="">-- Select Type --</option>
                      <option value="privacies">Privacy Policy</option>
                      <option value="terms">Terms And Condition</option>
                    </select>
                </div>
               

                <div class="form-group">
                    <label>Section Heading</label>
                    <input type="text"
                           name="sections[${sectionIndex}][heading]"
                           class="form-control"
                           placeholder="Enter section heading"
                           >
                </div>

                <div class="form-group">
                    <label>Section Description</label>
                    <textarea name="sections[${sectionIndex}][body]"
                              class="form-control editor"
                              rows="6"
                              ></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Order</label>
                            <input type="number"
                                   name="sections[${sectionIndex}][sort_order]"
                                   class="form-control"
                                   value="${sectionIndex}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="sections[${sectionIndex}][status]"
                                    class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
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
