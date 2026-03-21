@php
  $currency = $cartItems->first()?->course?->pricing?->currency_symbol ?? '$';
@endphp
@extends('home.layouts.app')
@push('styles')
  <style>
    .container.py-5 {
      max-width: 1280px;
    }

    /* theme color #0B8E96 – used for headings, buttons, badges, pagination */
    .theme-teal {
      color: #0B8E96;
    }

    h3.mb-4 {
      font-weight: 600;
      font-size: 2rem;
      letter-spacing: -0.02em;
      position: relative;
      display: inline-block;
      padding-bottom: 0.5rem;
      border-bottom: 3px solid rgba(11, 142, 150, 0.25);
      color: #1e2a3a;
    }

    h3.mb-4 i,
    h3.mb-4 span {
      color: #0B8E96;
      margin-right: 0.3rem;
    }

    /* card styling – clean, minimal, with teal hover border */
    .card {
      border: none;
      background: #ffffff;
      border-radius: 1.2rem;
      box-shadow: 0 10px 25px -8px rgba(0, 40, 50, 0.1), 0 2px 6px rgba(0, 0, 0, 0.02);
      overflow: hidden;
      border: 1px solid rgba(11, 142, 150, 0.08);
    }



    .card-img-top {
      height: 180px;
      object-fit: cover;
      background-color: #e9f2f3;
      /* placeholder hint */
      border-bottom: 2px solid rgba(11, 142, 150, 0.1);
    }

    .card-body {
      padding: 1.5rem 1.2rem 1.4rem;
    }

    .card-body h6 {
      font-weight: 600;
      font-size: 1.2rem;
      margin-bottom: 1.2rem;
      color: #1b3b44;
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 3.2rem;
    }

    /* primary button with theme color */
    .btn-primary {
      background-color: #0B8E96;
      border-color: #0B8E96;
      font-weight: 500;
      letter-spacing: 0.01em;
      padding: 0.5rem 1.4rem;
      border-radius: 40px;
      box-shadow: 0 6px 12px -6px rgba(11, 142, 150, 0.4);

      border: 1px solid #0B8E96;
    }

    .btn-primary:hover {
      background-color: #09757c;
      border-color: #086a70;

    }

    .btn-primary:active {
      background-color: #0a7f87 !important;
      border-color: #0a7f87 !important;
    }

    .btn-primary:focus-visible {
      background-color: #0B8E96;
      border-color: #0B8E96;
      box-shadow: 0 0 0 0.25rem rgba(11, 142, 150, 0.4);
    }

    /* alert info – using theme color but lighter */
    .alert-info {
      background-color: rgba(11, 142, 150, 0.08);
      color: #165a66;
      border: 1px solid rgba(11, 142, 150, 0.3);
      border-radius: 40px;
      font-size: 1.1rem;
      padding: 1.2rem 1.8rem;
      font-weight: 450;
      backdrop-filter: blur(2px);
    }


    .heart-decor {
      color: #0B8E96;
      filter: drop-shadow(0 2px 4px rgba(11, 142, 150, 0.2));
    }


    .alert-info i {
      color: #0B8E96;
      margin-right: 8px;
    }


    :focus-visible {
      outline: 2px solid #0B8E96;
      outline-offset: 2px;
    }


    @media (max-width: 576px) {
      h3.mb-4 {
        font-size: 1.8rem;
      }

      .card-body h6 {
        font-size: 1rem;
      }
    }
  </style>
@endpush

@section('content')
  <div class="container py-5">
    <h3 class="mb-4">
      <i class="fas fa-shopping-cart heart-decor"></i>
      <span>Shopping Cart</span>
    </h3>

    <div class="row g-4">

      {{-- LEFT SIDE - CART ITEMS --}}
      <div class="col-lg-8">

        @if ($cartItems->count() > 0)
          @php
            $subTotal = 0;
          @endphp

          @foreach ($cartItems as $item)
            @php
              $course = $item->course;
              $price = $course->pricing->price ?? 0;
              $subTotal += $price;
            @endphp

            <div class="card mb-4" style="overflow-y: auto">
              <div class="card-body d-flex align-items-center gap-4">

                {{-- Thumbnail --}}
                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="rounded"
                  style="width:180px;height:120px;object-fit:cover;">

                {{-- Course Info --}}
                <div class="flex-grow-1">
                  <h6 class="mb-2">{{ $course->title }}</h6>
                  <p class="text-muted mb-1">
                    Instructor: {{ $course->user->name }}
                  </p>

                  @if ($price > 0)
                    <p class="fw-semibold theme-teal mb-0">
                      {{ $course->pricing->currency_symbol ?? '$' }}{{ number_format($price, 2) }}
                    </p>
                  @else
                    <p class="text-success fw-semibold mb-0">Free</p>
                  @endif
                </div>

                {{-- Remove Button --}}
                <form action="{{ route('cart.remove', $course->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm" type="submit">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>

              </div>
            </div>
          @endforeach

          @if ($cartItems->count() > 0)
            <div class="mb-3 text-end">
              <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" type="submit"
                  onclick="return confirm('Are you sure you want to clear the cart?')">
                  <i class="fas fa-trash me-1"></i> Clear Cart
                </button>
              </form>
            </div>
          @endif
        @else
          <div class="alert alert-info text-center">
            <i class="fas fa-cart-shopping"></i>
            Your cart is empty.
          </div>
        @endif
      </div>


      {{-- RIGHT SIDE - SUMMARY --}}
      <div class="col-lg-4">
        <div class="card sticky-top p-3" style="top:100px;">
          <div class="card-body">

            <h5 class="fw-semibold mb-3">Order Summary</h5>

            <div class="d-flex justify-content-between mb-2">
              <span>Subtotal</span>
              <span class="fw-semibold">
                {{ $currency }}{{ number_format($subTotal ?? 0, 2) }}
              </span>
            </div>

            <div class="d-flex justify-content-between mb-3">
              <span>Total Items</span>
              <span>{{ $cartItems->count() }}</span>
            </div>

            <hr>

            <div class="d-flex justify-content-between mb-4">
              <h5>Total</h5>
              <h5 class="theme-teal">
                {{ $currency }}{{ number_format($subTotal ?? 0, 2) }}
              </h5>
            </div>

            <a href="" class="btn btn-primary w-100 mb-3">
              Proceed to Checkout
            </a>

            <p class="small text-muted text-center">
              By completing your purchase you agree to our
              <a href="#">Terms of Service</a>
            </p>

          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
