<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | Course Builder</title>

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f4f6f9;
    }

    /* Fixed sidebar adjustments */
    .wrapper {
      display: flex;
      flex-direction: row;
    }

    .main-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      width: 250px;
      z-index: 1030;
      background-color: #343a40;
      overflow-y: auto;
      border-right: 1px solid #495057;
    }

    .main-sidebar .sidebar {
      background-color: #343a40;
      color: #fff;
      padding: 1.5rem 0;
    }

    .main-sidebar .sidebar h5 {
      color: #fff;
      font-weight: 600;
      border-bottom: 1px solid #495057;
      padding: 0 1.5rem 0.75rem 1.5rem;
      margin-bottom: 1rem;
      margin-top: 0;
    }

    /* Nav sidebar styling */
    .main-sidebar .nav-sidebar {
      list-style: none;
      padding-left: 0;
      margin-bottom: 0;
    }

    .main-sidebar .nav-sidebar .nav-item {
      margin-bottom: 0;
    }

    .main-sidebar .nav-sidebar .nav-link {
      color: #c9c9c9;
      padding: 0.75rem 1.5rem;
      border-radius: 0;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      text-decoration: none;
    }

    .main-sidebar .nav-sidebar .nav-link:hover {
      background-color: #495057;
      color: #fff;
    }

    .main-sidebar .nav-sidebar .nav-link.active {
      background-color: #007bff;
      color: #fff;
      border-left: 3px solid #0056b3;
      padding-left: calc(1.5rem - 3px);
    }

    .main-sidebar .nav-sidebar .nav-icon {
      margin-right: 0.75rem;
      width: 1.5rem;
      text-align: center;
    }

    .main-sidebar .nav-sidebar .nav-link p {
      margin-bottom: 0;
    }

    .main-sidebar .nav {
      gap: 0;
    }

    .content-wrapper {
      margin-left: 250px;
      min-height: 100vh;
      background-color: #f4f6f9;
      flex: 1;
    }

    .navbar {
      position: sticky;
      top: 0;
      z-index: 1020;
      background: white;
      border-bottom: 1px solid #dee2e6;
    }

    /* Disabled link styling */
    .nav-link.disabled {
      opacity: 0.6;
      pointer-events: none;
      cursor: not-allowed;
    }

    /* Custom scrollbar for sidebar */
    .main-sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .main-sidebar::-webkit-scrollbar-track {
      background: #2c3b41;
    }

    .main-sidebar::-webkit-scrollbar-thumb {
      background: #555;
      border-radius: 3px;
    }

    .nav-link.disabled-link {
      pointer-events: none;
      opacity: 0.5;
      cursor: not-allowed;
    }

    .nav-badge {
      margin-left: auto;
      font-size: 12px;
    }



    .disabled-link {
      cursor: not-allowed;
      pointer-events: none;
      opacity: 0.5;
    }

    .upload-info {
      background: #f8fafc;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 14px 16px;
      font-size: 14px;
    }

    .info-icon {
      width: 32px;
      height: 32px;
      background: #e0f2fe;
      color: #0284c7;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
    }


    /* Badge styling */
    .badge-check {
      background: #28a745;
      color: #fff;
      border-radius: 50%;
      padding: 4px 6px;
      font-size: 11px;
    }

    .badge-count {
      background: #17a2b8;
      color: #fff;
      border-radius: 12px;
      padding: 2px 8px;
      font-size: 11px;
    }


    /* Modal backdrop */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      inset: 0;
      background: rgba(0, 0, 0, 0.55);
      backdrop-filter: blur(3px);
      animation: fadeIn 0.25s ease;
    }

    /* Modal box */
    .modal-content {
      background: #ffffff;
      width: 420px;
      max-width: 90%;
      margin: 10% auto;
      border-radius: 10px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
      animation: scaleIn 0.25s ease;
    }

    /* Inner spacing */
    .modal .container {
      padding: 24px;
    }

    /* Title */
    .modal h3,
    .modal h1 {
      margin: 0 0 10px;
      font-size: 20px;
      font-weight: 600;
      color: #1f2937;
    }

    /* Description text */
    .modal p {
      margin: 0 0 20px;
      font-size: 14px;
      color: #6b7280;
    }

    /* Close (×) */
    .modal .close {
      position: absolute;
      top: 16px;
      right: 20px;
      font-size: 26px;
      color: #6b7280;
      cursor: pointer;
      transition: color 0.2s ease;
    }

    .modal .close:hover {
      color: #dc3545;
    }

    /* Button container */
    .modal .clearfix {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    /* Cancel button */
    .modal .cancelbtn {
      background: #e5e7eb;
      color: #374151;
      border: none;
      padding: 8px 14px;
      font-size: 14px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    .modal .cancelbtn:hover {
      background: #d1d5db;
    }

    /* Delete button */
    .modal .deletebtn {
      background: #dc3545;
      color: #fff;
      border: none;
      padding: 8px 16px;
      font-size: 14px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s ease, transform 0.15s ease;
    }

    .modal .deletebtn:hover {
      background: #c82333;
    }

    .modal .deletebtn:active {
      transform: scale(0.95);
    }

    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes scaleIn {
      from {
        transform: scale(0.9);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .publish-card {
      border-radius: 6px;
      box-shadow: 0 1px 4px rgba(16, 24, 40, 0.06);
    }

    .publish-card h4 {
      font-weight: 700;
    }

    .publish-card .badge {
      font-size: 12px;
      padding: 6px 10px;
      border-radius: 20px;
    }

    .publish-card .price-badge {
      font-size: 22px;
    }

    .publish-card .lectures-badge {
      display: flex;
      align-items: center;
      gap: 4px;
    }
  </style>

  @stack('css')
</head>

<body class="hold-transition">

  <div class="wrapper">
    <!-- Sidebar Wrapper -->
    <aside class="main-sidebar">
      <div class="sidebar">
        <x-course-builder-sidebar :course="$course" />
      </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <!-- Top Navigation -->
      <nav class="navbar navbar-expand navbar-white navbar-light">
        <div class="container-fluid">
          <a href="{{ route('teacher.courses.index') }}" class="navbar-brand">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Courses
          </a>
          <div class="navbar-nav ml-auto">
            <span class="nav-link">
              <i class="fas fa-user-circle mr-1"></i>
              {{ auth()->user()->name ?? 'Guest' }}
            </span>
          </div>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="content p-4">
        <div class="container-fluid">
          @if (session('success') || session('error') || $errors->any())
            @push('scripts')
              <script>
                document.addEventListener('DOMContentLoaded', function() {
                  toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 4000,
                    extendedTimeOut: 1000,
                    positionClass: "toast-top-right",
                  };

                  @if (session('success'))
                    toastr.success(@json(session('success')));
                  @endif

                  @if (session('error'))
                    toastr.error(@json(session('error')));
                  @endif

                  @if ($errors->any())
                    toastr.warning(@json($errors->first()));
                  @endif

                });
              </script>
            @endpush
          @endif

          {{-- modal --}}
          <div id="deleteModal" class="modal">
            <span class="close">&times;</span>

            <div class="modal-content">
              <div class="container">
                <h3 id="deleteModalTitle">Delete</h3>
                <p id="deleteModalMessage">Are you sure?</p>

                <div class="clearfix">
                  <button type="button" class="cancelbtn">Cancel</button>
                  <button type="button" class="deletebtn">Delete</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Page Header -->
          <div class="mb-4">
            <h3 class="mb-0">
              @yield('page-title', 'Edit Course')
            </h3>
            <p class="text-muted mb-0">
              @yield('page-subtitle', 'Manage your course content')
            </p>
            <hr>
          </div>

          @yield('content')
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

    $(document).on('click', '.nav-link.disabled', function(e) {
      e.preventDefault();
      toastr.warning('Please complete previous steps first');
    });

    let currentForm = null;
    const modal = document.getElementById('deleteModal'); // your modal
    const actionBtn = modal.querySelector('.deletebtn'); // modal action button

    // Open modal on any trigger
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.open-delete-modal');
      if (!btn) return;

      currentForm = btn.closest('form');

      // Set modal title/message
      document.getElementById('deleteModalTitle').textContent =
        btn.dataset.title || 'Action';
      document.getElementById('deleteModalMessage').textContent =
        btn.dataset.message || 'Are you sure?';

      // Update modal button based on action
      const action = btn.dataset.action || 'delete';
      if (action === 'delete') {
        actionBtn.textContent = 'Delete';
        actionBtn.style.backgroundColor = '#dc3545';
        actionBtn.style.color = '#fff';
      } else if (action === 'publish') {
        actionBtn.textContent = 'Publish';
        actionBtn.style.backgroundColor = '#16a34a';
        actionBtn.style.color = '#fff';
      }

      modal.style.display = 'block';
    });

    // Close modal
    modal.querySelector('.close').onclick =
      modal.querySelector('.cancelbtn').onclick = () => {
        modal.style.display = 'none';
        currentForm = null;
      };

    // Submit form when modal action button is clicked
    actionBtn.onclick = () => {
      if (currentForm) currentForm.submit();
    };

    // Close modal when clicking outside
    window.onclick = e => {
      if (e.target === modal) modal.style.display = 'none';
    };
  </script>

  @stack('scripts')
</body>

</html>
