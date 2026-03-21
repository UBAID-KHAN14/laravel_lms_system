@extends('adminlte::page')

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <style>
    .form-label {
      font-weight: 500;
      color: #495057;
      margin-bottom: 8px;
    }

    .form-control,
    .form-select {
      border-radius: 6px;
      border: 1px solid #d2d6de;
      transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #3c8dbc;
      box-shadow: 0 0 0 0.2rem rgba(60, 141, 188, 0.25);
    }



    .btn-primary:hover {
      background-color: #0e6dd1;
      border-color: #0e6dd1;
    }

    .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
    }

    .card-header {
      background-color: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
      font-weight: 600;
      color: #000000;
      border-top: 3px solid #007bff;
    }

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
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .image-preview {
      max-width: 100%;
      max-height: 100px;
      border-radius: 4px;
      border: 1px solid #d2d6de;
      padding: 3px;
      background-color: white;
    }

    .small-image-preview {
      max-width: 60px;
      max-height: 60px;
      border-radius: 4px;
      border: 1px solid #d2d6de;
      padding: 2px;
      background-color: white;
    }

    .favicon-preview {
      max-width: 32px;
      max-height: 32px;
      border-radius: 4px;
      border: 1px solid #d2d6de;
      padding: 2px;
      background-color: white;
    }

    .field-hint {
      font-size: 0.85rem;
      color: #6c757d;
      margin-top: 5px;
      font-style: italic;
    }

    .form-section {
      margin-bottom: 30px;
    }

    .section-title {
      color: #3c8dbc;
      font-weight: 600;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }
  </style>
@endpush

@section('title')
  Site Settings
@endsection

@include('messages.toast')
@section('content_header')
  <h1>Site Settings</h1>
@endsection

@section('content')
  <div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title text-black">
              <i class="fas fa-cog mr-2"></i>Site Settings
            </h3>
          </div>
          <div class="card-body">
            <form id="siteSettingsForm" action="{{ route('admin.settings.update') }}" method="POST"
              enctype="multipart/form-data">
              @csrf
              <!-- General Information Section -->
              <div class="form-section">
                <h4 class="section-title text-black">
                  <i class="bi bi-info-circle me-2"></i>General Information
                </h4>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="site_name" class="form-label">Website Name</label>
                    <input type="text" name="site_name" id="site_name" value="{{ $setting->site_name ?? '' }}"
                      class="form-control" placeholder="Enter your website name">

                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="site_email" class="form-label">Website Email</label>
                    <input type="email" name="site_email" value="{{ $setting->site_email ?? '' }}" id="site_email"
                      class="form-control" placeholder="admin@example.com">

                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="site_phone" class="form-label">Website Phone</label>
                    <input type="text" name="site_phone" value="{{ $setting->site_phone ?? '' }}" id="site_phone"
                      class="form-control" placeholder="+1 (555) 123-4567">

                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="site_address" class="form-label">Website Address</label>
                    <textarea name="site_address" id="site_address" class="form-control" rows="1"
                      placeholder="123 Main Street, City, Country">{{ $setting->site_address ?? '' }}</textarea>

                  </div>
                </div>
              </div>

              <!-- Branding Section -->
              <div class="form-section">
                <h4 class="section-title text-black">
                  <i class="bi bi-palette me-2"></i>Branding & Logos
                </h4>

                <div class="row">
                  <!-- Main Logo -->
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Main Logo</label>
                    <div class="file-upload-container" id="logoUploadArea">
                      <input type="file" class="d-none" id="logo" name="logo" accept="image/*">
                      <div class="file-upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                      </div>
                      <div class="file-upload-text">Click to upload main logo</div>

                    </div>
                    <div class="image-preview-container" id="logoPreview">

                      @if (empty($setting) || empty($setting->logo))
                        <span>no Logo</span>
                      @else
                        <img src="{{ asset('storage/' . $setting->logo) }}" width="200px">
                      @endif
                    </div>
                  </div>



                  <!-- Favicon -->
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Favicon</label>
                    <div class="file-upload-container" id="faviconUploadArea">
                      <input type="file" class="d-none" id="favicon" name="favicon" accept="image/*">
                      <div class="file-upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                      </div>
                      <div class="file-upload-text">Click to upload favicon</div>

                    </div>
                    <div class="image-preview-container" id="faviconPreview">
                      @if (empty($setting) || empty($setting->favicon))
                        <span>no favicon</span>
                      @else
                        <img src="{{ asset('storage/' . $setting->favicon) }}" alt="" width="200px">
                      @endif
                    </div>
                  </div>
                </div>
              </div>

              <!-- Form Actions -->
              <div class="row mt-4">
                <div class="col-12">
                  <div class="d-flex justify-content-end align-items-center border-top pt-3">
                    <button type="reset" class="btn btn-outline-secondary" id="resetBtn">
                      <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Changes
                    </button>
                    <button type="submit" class="btn btn-dark ms-2">
                      <i class="bi bi-check-circle me-1"></i>Save Settings

                    </button>
                  </div>
                </div>
              </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // DOM Elements
    const logoUploadArea = document.getElementById('logoUploadArea');
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logoPreview');
    const faviconUploadArea = document.getElementById('faviconUploadArea');
    const faviconInput = document.getElementById('favicon');
    const faviconPreview = document.getElementById('faviconPreview');
    const siteSettingsForm = document.getElementById('siteSettingsForm');
    const resetBtn = document.getElementById('resetBtn');

    // File upload click handlers
    logoUploadArea.addEventListener('click', () => logoInput.click());
    faviconUploadArea.addEventListener('click', () => faviconInput.click());

    // Handle logo file selection
    logoInput.addEventListener('change', function(e) {
      if (this.files && this.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.alt = "Logo Preview";
          img.className = "image-preview mt-2";

          logoPreview.innerHTML = '<div class="field-hint">New logo preview:</div>';
          logoPreview.appendChild(img);

          // Update upload area text
          const fileName = logoInput.files[0].name;
          logoUploadArea.querySelector('.file-upload-text').textContent = fileName;
          logoUploadArea.querySelector('.file-upload-info').textContent = 'Click to change';
        };

        reader.readAsDataURL(this.files[0]);
      }
    });



    // Handle favicon file selection
    faviconInput.addEventListener('change', function(e) {
      if (this.files && this.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.alt = "Favicon Preview";
          img.className = "favicon-preview mt-2";

          faviconPreview.innerHTML = '<div class="field-hint">New favicon:</div>';
          faviconPreview.appendChild(img);

          // Update upload area text
          const fileName = faviconInput.files[0].name;
          faviconUploadArea.querySelector('.file-upload-text').textContent = fileName;
          faviconUploadArea.querySelector('.file-upload-info').textContent = 'Click to change';
        };

        reader.readAsDataURL(this.files[0]);
      }
    });


    // Reset button handler
    resetBtn.addEventListener('click', function() {
      if (confirm('Are you sure you want to reset all changes? Any unsaved changes will be lost.')) {
        siteSettingsForm.reset();

        // Reset previews
        logoPreview.innerHTML =
          '<div class="field-hint">Current logo preview:</div><img src="https://via.placeholder.com/300x100/3c8dbc/ffffff?text=Logo" alt="Logo Preview" class="image-preview mt-2">';
        logoSmallPreview.innerHTML =
          '<div class="field-hint">Current small logo:</div><img src="https://via.placeholder.com/60x60/3c8dbc/ffffff?text=S" alt="Small Logo Preview" class="small-image-preview mt-2">';
        faviconPreview.innerHTML =
          '<div class="field-hint">Current favicon:</div><img src="https://via.placeholder.com/32x32/3c8dbc/ffffff?text=F" alt="Favicon Preview" class="favicon-preview mt-2">';

        // Reset upload area text
        logoUploadArea.querySelector('.file-upload-text').textContent = 'Click to upload main logo';
        logoUploadArea.querySelector('.file-upload-info').textContent = 'Recommended: 300x100px';

        logoSmallUploadArea.querySelector('.file-upload-text').textContent = 'Click to upload small logo';
        logoSmallUploadArea.querySelector('.file-upload-info').textContent = 'Recommended: 60x60px';

        faviconUploadArea.querySelector('.file-upload-text').textContent = 'Click to upload favicon';
        faviconUploadArea.querySelector('.file-upload-info').textContent = 'Recommended: 32x32px';

        // Show reset confirmation
        if (typeof toastr !== 'undefined') {
          toastr.info('Form has been reset to default values.');
        } else {
          alert('Form has been reset to default values.');
        }
      }
    });
  </script>
@endpush
