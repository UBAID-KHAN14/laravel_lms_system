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

    .policy-container {
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

    .data-category {
      margin-bottom: 30px;
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 8px;
    }

    @media (max-width: 768px) {
      .policy-container {
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
          <h1 class="h2 fw-bold mb-3">Privacy Policy</h1>
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
    <div class="policy-container">

      <!-- Introduction (optional static) -->
      <div class="mb-5">
        <p class="lead">
          This Privacy Policy explains how we collect, use, store, and protect personal information
          in our Learning Management System (LMS).
        </p>
      </div>

      <!-- Dynamic Sections -->
      @foreach ($privacies as $privacy)
        <div class="mb-5" id="section-{{ $privacy->sort_order }}">
          <h3 class="section-title">
            {{ $privacy->heading }}
          </h3>

          {{-- BODY COMES FROM DATABASE --}}
          {!! $privacy->body !!}
        </div>
      @endforeach

      <!-- Last Updated -->
      <div class="border-top mt-5 pt-4 text-center">
        <p class="text-muted small mb-0">
          This Privacy Policy was last updated on {{ date('F d, Y') }}
        </p>
      </div>

      <div class="info-box mt-4">
        <p class="mb-0"> <strong>Contact:</strong> System Administrator<br> <strong>Email:</strong>
          {{ $setting->site_email ?? 'ubaidkhandev2004@gmail.com' }}<br> <strong>Phone:</strong>
          {{ $setting->site_phone ?? '+92 XXX XXXXXXX' }} </p>
      </div>
    </div>

  </div>
  </div>
@endsection
