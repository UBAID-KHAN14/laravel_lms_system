@extends('home.layouts.app')
@push('styles')
  <style>
    :root {
      --primary-color: #0B8E96;
      --primary-light: #E8F6F7;
      --primary-dark: #08747A;
      --text-color: #333;
      --light-gray: #f8f9fa;
      --border-color: #dee2e6;
    }

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background-color: #f9fbfc;
      color: var(--text-color);
      line-height: 1.6;
    }
  </style>
@endpush

@section('content')
  <div class="container py-5">

    <!-- Success/Error Messages -->

    {{-- <div id="formFeedback" class="form-feedback"></div> --}}

    <div class="row g-4">

      <!-- Contact Information -->
      <div class="col-lg-5">
        <div class="card-contact card h-100">
          <div class="card-body p-lg-5 p-4">
            <div class="mb-4 text-center">
              <div class="contact-icon mx-auto">
                <i class="fas fa-comments"></i>
              </div>
              <h3 class="fw-bold primary-text">Get In Touch</h3>
              <p class="text-muted">Our team is here to provide you with personalized support and answer any questions
                you may have.</p>
            </div>

            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div class="info-content">
                <h6>Our Office</h6>
                <p>{{ $setting->site_address }}</p>
              </div>
            </div>

            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <div class="info-content">
                <h6>Email Address</h6>
                <p>{{ $setting->site_email }}</p>
              </div>
            </div>

            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-phone"></i>
              </div>
              <div class="info-content">
                <h6>Phone Number</h6>
                <p>{{ $setting->site_phone }}<br>Mon-Fri 9am-6pm</p>
              </div>
            </div>

            <hr class="my-4">

            <div>
              <h5 class="section-title">Follow Us</h5>
              <div class="social-links">
                @foreach ($socialLinks as $socialLink)
                  <a href="#" class="social-icon">
                    <i class="{{ $socialLink->icon_class }}"></i>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-7">
        <div class="card-contact card h-100">
          <div class="card-body p-lg-5 p-4">
            <h3 class="section-title fw-bold">Send us a message</h3>
            <p class="text-muted mb-4">Please fill out the form below and we'll get back to you as soon as possible.</p>

            <form id="contactForm" method="POST" action="{{ route('contact.send') }}">
              @csrf

              <div class="row g-3">
                <div class="col-md-6">
                  <div class="floating-label">
                    <input type="text" class="form-control" id="name" name="name" placeholder=" " required>
                    <label for="name">Full Name *</label>
                    <div class="invalid-feedback" id="nameError">Please enter your name.</div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="floating-label">
                    <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                    <label for="email">Email Address *</label>
                    <div class="invalid-feedback" id="emailError">Please enter a valid email address.</div>
                  </div>
                </div>
              </div>

              <div class="floating-label">
                <input type="text" class="form-control" id="subject" name="subject" placeholder=" " required>
                <label for="subject">Subject *</label>
                <div class="invalid-feedback" id="subjectError">Please enter a subject.</div>
              </div>

              <div class="mb-4">
                <label for="message" class="form-label">Message *</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="How can we help you?" required></textarea>
                <div class="invalid-feedback" id="messageError">Please enter your message.</div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary-custom submit-btn" id="submitBtn">
                  <span id="btnText">Send Message</span>
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
              </div>

              <p class="text-muted small mt-3">By submitting this form, you agree to our <a href="#"
                  class="primary-text text-decoration-none">Privacy Policy</a>.</p>
            </form>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection
