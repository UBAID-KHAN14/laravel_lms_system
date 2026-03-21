@extends('adminlte::page')
@push('css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <style>
    .file-upload-container {
      border: 2px dashed #d2d6de;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      background-color: #f8f9fa;
      cursor: pointer;
      transition: all 0.3s;
    }

    .file-upload-container:hover {
      border-color: #3c8dbc;
      background-color: #f0f8ff;
    }

    .file-upload-icon {
      font-size: 2rem;
      color: #3c8dbc;
      margin-bottom: 10px;
    }

    .file-upload-text {
      font-weight: 500;
      margin-bottom: 5px;
      color: #495057;
    }

    .file-upload-info {
      font-size: 0.85rem;
      color: #6c757d;
    }

    .image-preview-container {
      margin-top: 15px;
    }


    .small-image-preview {
      max-width: 200px;
      border-radius: 4px;
      border: 1px solid #d2d6de;
      padding: 2px;
      background-color: white;
    }
  </style>
@endpush
@section('content')
  <!--begin::Row-->
  @if ($errors->any())
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif
  <div class="row g-4">

    <!--begin::Col-->
    <div class="col-md-12">
      <!--begin::Quick Example-->
      <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
          <div class="card-title">Edit Social Link</div>
          <div style="display: flex;justify-content: end;">
            <a href="{{ route('admin.socialLinks.index') }}" class="btn btn-outline-primary"><i
                class="fas fa-arrow-left mr-1"></i> Back to Social Links</a>
          </div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form action="{{ route('admin.socialLinks.update', $socialLink->id) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="row">

              <!-- Full Name -->
              <div class="col-md-12 mb-3">
                <label>Icon Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name', $socialLink->name) }}">
                @error('name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Full Name -->
              <div class="col-md-12 mb-3">
                <label>Icon Url <span class="text-danger">*</span></label>
                <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
                  value="{{ old('url', $socialLink->url) }}">
                @error('url')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Full Name -->
              <div class="col-md-12 mb-3">
                <label>Icon Class <span class="text-danger">*</span></label>
                <input type="text" name="icon_class" class="form-control @error('icon_class') is-invalid @enderror"
                  value="{{ old('icon_class', $socialLink->icon_class) }}" placeholder="e.g. fab fa-facebook-f">
                @error('icon_class')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>



              <div class="col-md-6 mb-3">
                <label class="form-label d-block">Status</label>
                <div class="d-flex align-items-center gap-3">
                  <!-- inactive = 0 -->
                  <input type="hidden" name="status" value="0">
                  <!-- Active = 1  -->
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                      {{ $socialLink->status == '1' ? 'checked' : '' }}>
                  </div>
                  <span id="statusText" class="badge bg-success">Active</span>
                </div>
              </div>

            </div>

            <div class="card-footer text-right">
              <button type="reset" class="btn btn-outline-secondary"><i class="fas fa-undo mr-1"></i> Reset</button>
              <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> Save</button>
            </div>
        </form>


        <!--end::Form-->
      </div>
      <!--end::Quick Example-->


    </div>
    <!--end::Col-->

  </div>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const checkbox = document.getElementById('status');
    const text = document.getElementById('statusText');

    // Initial state on page load
    if (checkbox.checked) {
      text.textContent = 'Active';
      text.classList.add('bg-success');
    } else {
      text.textContent = 'Inactive';
      text.classList.add('bg-danger');
    }

    // Listen for changes
    checkbox.addEventListener('change', function() {
      if (this.checked) {
        text.textContent = 'Active';
        text.classList.replace('bg-danger', 'bg-success');
      } else {
        text.textContent = 'Inactive';
        text.classList.replace('bg-success', 'bg-danger');
      }
    });
  </script>
@endpush
