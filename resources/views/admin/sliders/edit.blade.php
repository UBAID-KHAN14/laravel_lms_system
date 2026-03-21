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
          <div class="card-title">Edit Slider</div>

          {{-- back --}}
          <div class="card-tools">
            <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-outline-primary">
              <i class="fas fa-arrow-left"></i> Back to Sliders
            </a>
          </div>

        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="row">
              <!-- Small Logo -->
              <div class="col-md-12 mb-3">
                <label class="form-label">Image</label>
                <div class="file-upload-container" id="logoSmallUploadArea">
                  <input type="file" class="d-none" id="logo_small" name="image">
                  <div class="file-upload-icon">
                    <i class="bi bi-cloud-arrow-up"></i>
                  </div>
                  <div class="file-upload-text">Click to upload image</div>

                </div>
                <div class="image-preview-container" id="logoSmallPreview">
                  <div class="field-hint">Current Image:</div>
                  <img src="{{ asset('storage/' . $slider->image) }}" alt="" width="500px">
                </div>
              </div>
              <!-- Full Name -->
              <div class="col-md-12 mb-3">
                <label>Title <span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ old('title', $slider->title) }}"
                  class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                @error('title')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <!-- description -->
              <div class="col-md-12 mb-3">
                <label>Description</label>
                <textarea name="description" rows="3" class="form-control editor @error('description') is-invalid @enderror">{{ old('description', $slider->description) }}</textarea>
                @error('description')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label d-block">Status</label>
                <div class="d-flex align-items-center gap-3">
                  <!-- unchecked = 0 -->
                  <input type="hidden" name="status" value="0">
                  <!-- checked = 1 (Hidden) -->
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                      {{ $slider->status == 1 ? 'checked' : '' }}>
                  </div>
                  <span id="statusText" class="badge bg-success">Visible</span>
                </div>
              </div>

            </div>

            <div class="card-footer text-right">
              <button type="reset" class="btn btn-outline-secondary"><i class="fas fa-undo mr-1"></i> Reset</button>
              <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> Update</button>
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

    checkbox.addEventListener('change', function() {
      if (this.checked) {
        text.textContent = 'Hidden';
        text.classList.replace('bg-success', 'bg-danger');
      } else {
        text.textContent = 'Visible';
        text.classList.replace('bg-danger', 'bg-success');
      }
    });

    const logoSmallUploadArea = document.getElementById('logoSmallUploadArea');
    const logoSmallInput = document.getElementById('logo_small');
    const logoSmallPreview = document.getElementById('logoSmallPreview');


    logoSmallUploadArea.addEventListener('click', () => logoSmallInput.click());


    // Handle small logo file selection
    logoSmallInput.addEventListener('change', function(e) {
      if (this.files && this.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.alt = "Small Logo Preview";
          img.className = "small-image-preview mt-2";

          logoSmallPreview.innerHTML = '<div class="field-hint">New small logo:</div>';
          logoSmallPreview.appendChild(img);

          // Update upload area text
          const fileName = logoSmallInput.files[0].name;
          logoSmallUploadArea.querySelector('.file-upload-text').textContent = fileName;
          logoSmallUploadArea.querySelector('.file-upload-info').textContent = 'Click to change';
        };

        reader.readAsDataURL(this.files[0]);
      }
    });
  </script>
@endpush
