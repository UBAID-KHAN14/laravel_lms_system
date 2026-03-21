@extends('home.layouts.app')
@push('styles')
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
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .login-wrapper {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      border: 1px solid var(--border-color);
      overflow: hidden;
      width: 100%;
      max-width: 420px;
    }

    .login-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 25px;
      text-align: center;
    }

    .login-header h2 {
      margin: 0;
      font-weight: 700;
      font-size: 24px;
    }

    .login-header p {
      margin: 8px 0 0 0;
      opacity: 0.9;
      font-size: 15px;
    }

    .login-body {
      padding: 30px;
    }

    .form-label {
      font-weight: 600;
      color: #555;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-control {
      border: 1px solid var(--border-color);
      border-radius: 6px;
      padding: 12px 15px;
      font-size: 15px;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(11, 142, 150, 0.15);
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

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .form-check-input:checked {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .forgot-link {
      color: var(--primary-color);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
    }

    .forgot-link:hover {
      text-decoration: underline;
    }

    .btn-login {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      color: white;
      padding: 12px;
      font-weight: 600;
      border-radius: 6px;
      font-size: 16px;
      transition: all 0.3s;
      width: 100%;
    }

    .btn-login:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(11, 142, 150, 0.2);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .login-footer {
      text-align: center;
      margin-top: 25px;
      padding-top: 20px;
      border-top: 1px solid var(--border-color);
      color: #666;
      font-size: 15px;
    }

    .login-footer a {
      color: var(--primary-color);
      font-weight: 600;
      text-decoration: none;
    }

    .login-footer a:hover {
      text-decoration: underline;
    }

    .alert-message {
      background-color: var(--primary-light);
      border-left: 4px solid var(--primary-color);
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 14px;
    }

    .alert-message a {
      color: var(--primary-color);
      font-weight: 600;
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 25px 0;
      color: #999;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid var(--border-color);
    }

    .divider span {
      padding: 0 15px;
      font-size: 14px;
    }

    .social-login {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .social-btn {
      flex: 1;
      padding: 10px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      background: white;
      color: #666;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .social-btn:hover {
      background-color: #f8f9fa;
      border-color: #ccc;
    }

    .social-btn.google {
      color: #DB4437;
    }

    .social-btn.facebook {
      color: #4267B2;
    }

    .social-btn.github {
      color: #333;
    }

    @media (max-width: 576px) {
      .login-body {
        padding: 25px;
      }

      .login-header {
        padding: 20px;
      }

      .form-options {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .social-login {
        flex-direction: column;
      }
    }

    .error-message {
      color: #dc3545;
      font-size: 13px;
      margin-top: 5px;
      display: block;
    }
  </style>
@endpush

@section('content')



  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-header">
        <h2>Welcome Back</h2>
        <p>Sign in to continue your learning journey</p>
      </div>

      <div class="login-body">
        <!-- Activation Resend Form -->
        @if (session('show_resend_activation'))
          <div class="alert-message">
            <p class="mb-2">Your account needs activation. Please check your email or resend activation link:</p>
            <form method="POST" action="{{ route('resend.activation') }}" class="d-flex gap-2">
              @csrf
              <input type="email" class="form-control form-control-sm" name="email" value="{{ session('email') }}"
                required>
              <button type="submit" class="btn btn-sm btn-login" style="padding: 8px 15px;">Resend</button>
            </form>
          </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Login failed:</strong>
            <ul class="mb-0 mt-2">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Main Login Form -->
        <form id="loginForm" action="{{ route('login') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
              value="{{ old('email') }}" placeholder="Enter your email" required>
            @error('email')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="password-container">
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" placeholder="Enter your password" required>
              <button type="button" class="toggle-password" id="togglePassword">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            @error('password')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-options">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                Remember me
              </label>
            </div>
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt me-2"></i> Sign In
          </button>

          <!-- Social Login (Optional) -->
          <div class="divider">
            <span>Or continue with</span>
          </div>

          <div class="social-login">
            <button type="button" class="social-btn google">
              <i class="fab fa-google"></i> Google
            </button>
            <button type="button" class="social-btn facebook">
              <i class="fab fa-facebook-f"></i> Facebook
            </button>
            <button type="button" class="social-btn github">
              <i class="fab fa-github"></i> GitHub
            </button>
          </div>
        </form>

        <div class="login-footer">
          <p>Don't have an account? <a href="{{ route('register') }}">Create one now</a></p>
        </div>
      </div>
    </div>
  </div>




  @push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      @include('messages.message')
      @include('messages.sweet-error')
      document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
          const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordField.setAttribute('type', type);
          this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        // Form validation
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function(e) {
          const email = document.getElementById('email').value;
          const password = document.getElementById('password').value;

          if (!email || !password) {
            e.preventDefault();
            alert('Please fill in both email and password fields.');
          }
        });

        // Social login buttons (demo functionality)
        const socialButtons = document.querySelectorAll('.social-btn');
        socialButtons.forEach(button => {
          button.addEventListener('click', function() {
            const provider = this.classList.contains('google') ? 'Google' :
              this.classList.contains('facebook') ? 'Facebook' : 'GitHub';
            alert(`Demo: ${provider} login would be implemented here.`);
          });
        });

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
          setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
          }, 5000);
        });
      });
    </script>
  @endpush
@endsection
