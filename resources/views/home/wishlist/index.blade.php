@extends('home.layouts.app')
@push('styles')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    .course-card {
      border: none;
      font-size: 14px;
    }


    .course-card img {
      height: 140px;
      object-fit: cover;
    }

    .course-card .card-title {
      font-size: 14px;
      font-weight: 600;
    }

    .course-card .card-text {
      font-size: 12px;
    }

    .course-meta span {
      font-size: 12px;
    }

    .course-price {
      font-weight: 600;
      font-size: 14px;
    }

    .course-badge {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: var(--accent-color);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .course-price {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-color);
    }

    .card-img-top {
      border: 1px solid rgb(212, 205, 205)
    }

    .course-price.free {
      color: #28a745;
    }

    .course-meta {
      font-size: 0.9rem;
      color: #6c757d;
    }

    .course-meta i {
      margin-right: 0.25rem;
    }

    .no-courses {
      text-align: center;
      padding: 5rem 2rem;
    }

    .no-courses i {
      font-size: 4rem;
      color: #dee2e6;
      margin-bottom: 1rem;
    }

    .btn-primary {
      background-color: #0C9DA7;
      color: white;
      border: 1px solid #0C9DA7;
    }

    .btn-primary:hover {
      background-color: #0DA3AD;
      color: white;
      border: 1px solid #0C9DA7;
    }

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

    #searchInput {
      width: 200px;
      height: 40px;
      border-radius: 5px;
    }

    /* responsive refinements */
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
  <div class="container mt-5">
    <h3 class="d-flex justify-content-center mb-4">
      <span class="heart-decor"><i class="fas fa-heart"></i></span> My <span style="color:#0B8E96;">Wishlist</span>
    </h3>
    <div class="search-section">
      <form id="searchForm" method="GET" action="{{ route('wishlist.index') }}">
        <div class="row g-3 d-flex justify-content-end">
          {{-- Search Input --}}

          <div class="col-md-6 d-flex justify-content-end">
            <div class="search-box">
              <i class="fas fa-search search-icon"></i>
              <input type="text" name="search" id="searchInput" class="form-control"
                placeholder="Search courses by title, instructor, or keywords..." value="{{ request('search') }}">
            </div>
          </div>



        </div>
      </form>


    </div>
  </div>


  <div class="container py-5">
    <div id="coursesContainer">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3" id="wishlistResults">
        @include('home.wishlist.partials.wishlist_items')
      </div>


      @if ($wishlists->hasPages())
        <div class="col-12 mt-4">
          {{ $wishlists->withQueryString()->links() }}
        </div>
      @endif
    </div>

  </div>

  @push('js')
    <script>
      $(document).ready(function() {

        let delayTimer;

        function loadWishlist(url = "{{ route('wishlist.index') }}") {

          let search = $('#searchInput').val();

          $.ajax({
            url: url,
            type: "GET",
            data: {
              search: search
            },

            success: function(data) {
              $('#wishlistResults').html(data);
            }
          });

        }


        // SEARCH
        $('#searchInput').keyup(function() {

          clearTimeout(delayTimer);

          delayTimer = setTimeout(function() {
            loadWishlist();
          }, 400);

        });


        // PAGINATION
        $(document).on('click', '.pagination a', function(e) {

          e.preventDefault();

          let url = $(this).attr('href');

          loadWishlist(url);

        });

      });
    </script>
  @endpush
@endsection
