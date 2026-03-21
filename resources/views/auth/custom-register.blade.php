<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration | LMS Platform</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <style>
    :root {
      --primary-color: #0B8E96;
      --primary-light: #E8F6F7;
      --primary-dark: #08747A;
      --text-color: #333;
      --light-bg: #f9fbfc;
      --border-color: #dee2e6;
    }

    body {
      background-color: var(--light-bg);
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      color: var(--text-color);
      line-height: 1.6;
    }

    .registration-wrapper {
      padding: 30px 0;
    }

    .registration-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid var(--border-color);
      overflow: hidden;
      max-width: 800px;
      margin: 0 auto;
    }

    .registration-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 25px;
      text-align: center;
    }

    .registration-header h2 {
      margin: 0;
      font-weight: 700;
      font-size: 24px;
    }

    .registration-header p {
      margin: 5px 0 0 0;
      opacity: 0.9;
    }

    .registration-body {
      padding: 30px;
    }

    .section-title {
      color: var(--primary-color);
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--primary-light);
      position: relative;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 60px;
      height: 2px;
      background-color: var(--primary-color);
    }

    .form-label {
      font-weight: 600;
      color: #555;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-control,
    .form-select {
      border: 1px solid var(--border-color);
      border-radius: 6px;
      padding: 10px 15px;
      font-size: 15px;
      transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(11, 142, 150, 0.15);
    }

    .required-field::after {
      content: " *";
      color: #dc3545;
    }

    .profile-preview-container {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-top: 10px;
    }

    .profile-preview {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: var(--primary-light);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border: 3px solid white;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-preview i {
      font-size: 40px;
      color: var(--primary-color);
      opacity: 0.7;
    }

    .file-input-wrapper {
      flex: 1;
    }

    .file-input-wrapper .form-control {
      padding: 10px;
    }

    .btn-register {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      color: white;
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 6px;
      font-size: 16px;
      transition: all 0.3s;
      width: 100%;
      margin-top: 10px;
    }

    .btn-register:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(11, 142, 150, 0.2);
    }

    .error-message {
      color: #dc3545;
      font-size: 13px;
      margin-top: 5px;
      display: block;
    }

    .field-group {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      margin-top: 15px;
      border-left: 4px solid var(--primary-color);
    }

    .login-link {
      text-align: center;
      margin-top: 25px;
      padding-top: 20px;
      border-top: 1px solid var(--border-color);
      color: #666;
      font-size: 15px;
    }

    .login-link a {
      color: var(--primary-color);
      font-weight: 600;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .registration-body {
        padding: 20px;
      }

      .profile-preview-container {
        flex-direction: column;
        align-items: flex-start;
      }

      .profile-preview {
        margin-bottom: 15px;
      }

      .registration-header {
        padding: 20px;
      }

      .registration-header h2 {
        font-size: 20px;
      }
    }

    .form-row {
      margin-bottom: 20px;
    }

    .password-container {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #666;
      cursor: pointer;
      font-size: 14px;
    }
  </style>
</head>

<body>
  @include('home.partials.navbar')
  @include('home.partials.header')

  <div class="registration-wrapper container">
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="registration-card">
      <div class="registration-header">
        <h2>Create Your Account</h2>
        <p>Join our educational platform and start your learning journey</p>
      </div>

      <div class="registration-body">
        <form id="registrationForm" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Personal Information -->
          <div class="form-row">
            <h4 class="section-title">Personal Information</h4>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label required-field">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                  value="{{ old('name') }}" placeholder="Enter your full name" required>
                @error('name')
                  <span class="error-message">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label required-field">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ old('email') }}" placeholder="Enter your email" required>
                @error('email')
                  <span class="error-message">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="row g-3 mt-2">
              <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select class="form-select" name="gender">
                  <option value="">Select Gender</option>
                  <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                  <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"
                  placeholder="Enter phone number">
              </div>
            </div>
          </div>

          <!-- Account Information -->
          <div class="form-row mt-4">
            <h4 class="section-title">Account Information</h4>

            <div class="mb-3">
              <label class="form-label required-field">Register As</label>
              <select class="@error('requested_as') is-invalid @enderror form-select" name="requested_as"
                id="requested_as" required>
                <option value="">Select Account Type</option>
                <option value="teacher" {{ old('requested_as') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="student" {{ old('requested_as') == 'student' ? 'selected' : '' }}>Student</option>
              </select>
              @error('requested_as')
                <span class="error-message">{{ $message }}</span>
              @enderror
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label required-field">Password</label>
                <div class="password-container">
                  <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    id="password" placeholder="Create password" required>
                  <button type="button" class="toggle-password" id="togglePassword">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                @error('password')
                  <span class="error-message">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-md-6">
                <label class="form-label required-field">Confirm Password</label>
                <div class="password-container">
                  <input type="password" class="form-control" name="password_confirmation" id="confirmPassword"
                    placeholder="Confirm password" required>
                  <button type="button" class="toggle-password" id="toggleConfirmPassword">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Teacher Details (Hidden by default) -->
          <div id="teacherFields" class="field-group" style="display: none;">
            <h5 class="mb-3" style="color: var(--primary-color);">
              <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Information
            </h5>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Qualification</label>
                <input type="text" class="form-control" name="qualification" value="{{ old('qualification') }}"
                  placeholder="e.g., M.Sc, B.Ed">
              </div>

              <div class="col-md-6">
                <label class="form-label">Experience (Years)</label>
                <input type="number" class="form-control" name="experience" value="{{ old('experience') }}"
                  placeholder="e.g., 5" min="0" max="50">
              </div>
            </div>
          </div>

          <!-- Student Details (Hidden by default) -->
          <div id="studentFields" class="field-group" style="display: none;">
            <h5 class="mb-3" style="color: var(--primary-color);">
              <i class="fas fa-user-graduate me-2"></i>Student Information
            </h5>

            <div class="row g-3">
              <div class="col-md-12">
                <label class="form-label">Father's Name</label>
                <input type="text" class="form-control" name="father_name" value="{{ old('father_name') }}"
                  placeholder="Enter father's name">
              </div>

              <div class="col-md-6">
                <label class="form-label">Roll Number</label>
                <input type="text" class="form-control" name="roll_number" value="{{ old('roll_number') }}"
                  placeholder="Enter roll number">
              </div>

              <div class="col-md-6">
                <label class="form-label">Class</label>
                <input type="text" class="form-control" name="class_name" value="{{ old('class_name') }}"
                  placeholder="e.g., 10th, BSCS">
              </div>
            </div>
          </div>

          <!-- Profile Picture -->
          <div class="form-row mt-4">
            <h4 class="section-title">Profile Picture</h4>

            <div class="profile-preview-container">
              <div class="profile-preview" id="profilePreview">
                <i class="fas fa-user"></i>
              </div>

              <div class="file-input-wrapper">
                <label class="form-label">Upload Profile Image</label>
                <input type="file" class="form-control" name="image" id="profile_picture" accept="image/*"
                  onchange="previewImage(event)">
                <div class="form-text">Recommended size: 300x300 pixels. Max 2MB.</div>
              </div>
            </div>
          </div>
          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" name="accept_terms" id="accept_terms" required>

            <label class="form-check-label" for="accept_terms">
              I agree to the
              <a href="{{ route('home.terms_condition') }}" target="_blank">Terms & Conditions</a>
              and
              <a href="{{ route('home.privacy_policy') }}" target="_blank">Privacy Policy</a>
            </label>
          </div>

          @error('accept_terms')
            <small class="text-danger">{{ $message }}</small>
          @enderror


          <!-- Submit Button -->
          <div class="form-row mt-4">
            <button type="submit" class="btn btn-register">
              <i class="fas fa-user-plus me-2"></i> Create Account
            </button>

            <div class="login-link">
              Already have an account? <a href="{{ route('login') }}">Sign In Here</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const roleSelect = document.getElementById('requested_as');
      const teacherFields = document.getElementById('teacherFields');
      const studentFields = document.getElementById('studentFields');

      // Show/hide fields based on role selection
      roleSelect.addEventListener('change', function() {
        teacherFields.style.display = 'none';
        studentFields.style.display = 'none';

        if (this.value === 'teacher') {
          teacherFields.style.display = 'block';
        }

        if (this.value === 'student') {
          studentFields.style.display = 'block';
        }
      });

      // Set initial state based on old input
      if ("{{ old('requested_as') }}" === 'teacher') {
        teacherFields.style.display = 'block';
      } else if ("{{ old('requested_as') }}" === 'student') {
        studentFields.style.display = 'block';
      }

      // Password toggle functionality
      const togglePassword = document.getElementById('togglePassword');
      const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
      const passwordField = document.getElementById('password');
      const confirmPasswordField = document.getElementById('confirmPassword');

      togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
      });

      toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
      });

      // Form validation
      const form = document.getElementById('registrationForm');
      form.addEventListener('submit', function(e) {
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        if (password !== confirmPassword) {
          e.preventDefault();
          alert('Passwords do not match. Please check and try again.');
          confirmPasswordField.focus();
        }

        // Additional validation can be added here
      });
    });

    // Profile picture preview
    function previewImage(event) {
      const preview = document.getElementById('profilePreview');
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.innerHTML = `<img src="${e.target.result}" alt="Profile Preview">`;
        };
        reader.readAsDataURL(file);
      }
    }

    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  </script>

</body>

</html>
