@extends('home.layouts.app')
@push('styles')
  <style>
    :root {
      --primary-color: #0B8E96;
      --light-bg: #f8f9fa;
    }

    body {
      font-family: 'Segoe UI', system-ui, sans-serif;
      background-color: var(--light-bg);
      line-height: 1.6;
      color: #333;
    }

    .header {
      background-color: var(--primary-color);
      color: white;
      padding: 60px 0 40px;
      margin-bottom: 40px;
    }

    .terms-container {
      max-width: 900px;
      margin: 0 auto;
      background: white;
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .section-title {
      color: var(--primary-color);
      padding-bottom: 10px;
      margin-bottom: 20px;
      border-bottom: 2px solid var(--primary-color);
    }

    .info-box {
      background-color: #f8f9fa;
      border-left: 4px solid var(--primary-color);
      padding: 20px;
      border-radius: 5px;
      margin: 25px 0;
    }

    .warning-box {
      background-color: #fff3cd;
      border-left: 4px solid #ffc107;
      padding: 20px;
      border-radius: 5px;
      margin: 25px 0;
    }

    .list-group-item {
      border: none;
      padding-left: 0;
      padding-right: 0;
      background: transparent;
    }

    @media (max-width: 768px) {
      .terms-container {
        padding: 25px;
      }

      .header {
        padding: 40px 0 30px;
      }
    }
  </style>
@endpush

@section('content')
  <!-- Header -->
  <div class="header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
          <h1 class="h2 fw-bold mb-3">Terms and Conditions</h1>
          <p class="lead mb-0">Effective Date: 01 February 2026</p>
          <p class="mt-2">
            <span class="badge bg-light text-primary">Last Updated: {{ date('F d, Y') }}</span>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container">
    <div class="terms-container">

      <!-- Introduction -->
      <div class="mb-5">
        <p class="lead">These Terms and Conditions govern the use of our Learning Management System (LMS). By
          accessing or using the system, you agree to these terms.</p>
      </div>

      <!-- Dynamic Sections -->
      @foreach ($terms as $term)
        <div class="mb-5" id="section-{{ $term->sort_order }}">
          <h3 class="section-title">
            {{ $term->heading }}
          </h3>

          {{-- BODY COMES FROM DATABASE --}}
          {!! $term->body !!}
        </div>
      @endforeach



      <!-- Acceptance Section -->
      <div class="border-top mt-5 pt-4">
        <h4 class="mb-4">Agreement Confirmation</h4>

        <div class="row mb-4">
          <div class="col-md-6">
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="termsAgreement">
              <label class="form-check-label" for="termsAgreement">
                I have read and agree to the Terms and Conditions
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="privacyAgreement">
              <label class="form-check-label" for="privacyAgreement">
                I have read and agree to the Privacy Policy
              </label>
            </div>
          </div>
        </div>

        <div class="d-grid d-md-flex justify-content-md-end gap-2">
          <button class="btn btn-primary px-4" id="acceptTerms" disabled>
            Accept Terms
          </button>
        </div>

        <p class="text-muted small mb-0 mt-4">
          <i class="fas fa-info-circle me-1"></i>
          These terms were last updated on {{ date('F d, Y') }}
        </p>
      </div>

    </div>
  </div>

  @push('js')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Terms Agreement Check
        const termsCheckbox = document.getElementById('termsAgreement');
        const privacyCheckbox = document.getElementById('privacyAgreement');
        const acceptButton = document.getElementById('acceptTerms');

        function updateAcceptButton() {
          acceptButton.disabled = !(termsCheckbox.checked && privacyCheckbox.checked);
        }

        termsCheckbox.addEventListener('change', updateAcceptButton);
        privacyCheckbox.addEventListener('change', updateAcceptButton);

        acceptButton.addEventListener('click', function() {
          alert('Thank you for accepting our Terms and Conditions and Privacy Policy!');
          termsCheckbox.checked = false;
          privacyCheckbox.checked = false;
          updateAcceptButton();
        });
      });
    </script>
  @endpush
@endsection
