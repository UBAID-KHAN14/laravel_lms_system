@extends('home.layouts.app')
@push('styles')
  <style>
    :root {

      --accent-color: #0C9DA7;
      --light-bg: #f8f9fa;
      --dark-text: #2b2d42;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--dark-text);
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

    .courses-hero {
      background: linear-gradient(135deg, #0B8E96 0%, #0DA3AD 100%);
      color: white;
      padding: 3rem 0;
      margin-bottom: 2rem;
    }

    .search-section {
      background: white;
      border-radius: 15px;
      padding: 2rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      margin-top: -50px;
      position: relative;
      z-index: 10;
    }



    .search-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
    }

    .filter-card {
      background: white;
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      height: 100%;
    }

    .category-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-top: 1rem;
    }

    .category-tag {
      padding: 0.5rem 1rem;
      background: #f0f2ff;
      color: var(--primary-color);
      border-radius: 20px;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.2s ease;
      border: 1px solid transparent;
    }

    .category-tag:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-2px);
    }

    .category-tag.active {
      background: var(--primary-color);
      color: white;
      border-color: var(--primary-color);
    }

    /* ========== COURSE CARD STYLES (matching your course listing page) ========== */
    .course-card {
      border: none;
      font-size: 14px;
      background: white;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      height: 100%;
    }

    .course-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .course-card img {
      height: 140px;
      object-fit: cover;
      width: 100%;
      border-bottom: 1px solid rgb(212, 205, 205);
    }

    .course-card .card-title {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .course-card .card-text {
      font-size: 12px;
      color: #6c757d;
      margin-bottom: 0.8rem;
    }

    /* Position relative for overlay buttons */
    .position-relative {
      position: relative;
    }

    .card-img-overlay {
      position: absolute;
      top: 0;
      right: 0;
      left: auto;
      bottom: auto;
      padding: 0.75rem;
      background: transparent;
    }

    /* Wishlist button */
    .wishlist-btn {
      background: white;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #e74c3c;
      transition: all 0.2s;
      border: none;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .wishlist-btn:hover {
      background: #e74c3c;
      color: white;
      transform: scale(1.05);
    }

    /* Category badge */
    .course-card .badge.bg-light {
      background: #f1f5f9 !important;
      color: #2b2d42;
      font-size: 0.7rem;
      padding: 0.25rem 0.5rem;
    }

    /* Course meta info */
    .course-meta {
      font-size: 0.75rem;
      color: #6c757d;
      margin-bottom: 0.8rem;
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .course-meta i {
      margin-right: 0.2rem;
      color: var(--accent-color, #0C9DA7);
    }

    .course-meta span {
      font-size: 12px;
    }

    /* Price styling */
    .course-price {
      font-weight: 700;
      font-size: 1.1rem;
      color: var(--primary-color, #0B8E96);
    }

    .course-price.text-dark {
      color: #2b2d42;
    }

    /* Buttons inside card */
    .btn-primary {
      background-color: #0C9DA7;
      border: 1px solid #0C9DA7;
      padding: 0.3rem 0.8rem;
      font-size: 0.75rem;
      border-radius: 30px;
      transition: all 0.2s;
    }

    .btn-primary:hover {
      background-color: #0DA3AD;
      transform: translateY(-2px);
    }

    .btn-success {
      background-color: #28a745;
      font-size: 0.75rem;
      padding: 0.3rem 0.8rem;
    }

    /* Cart hover button (hidden by default, shown on card hover) */
    .cart-hover-btn {
      display: inline-block;
    }

    /* For the "Add to Cart" button that appears on hover (optional) */
    .course-card .cart-hover-btn .btn {
      transition: all 0.2s;
    }

    /* Star rating small */
    .text-warning small {
      font-size: 0.7rem;
    }

    /* No courses fallback */
    .no-courses {
      text-align: center;
      padding: 3rem;
    }

    .no-courses i {
      font-size: 3rem;
      color: #dee2e6;
      margin-bottom: 1rem;
    }

    .select2-container--default .select2-selection--single {
      height: 52px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      padding: 0.5rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 40px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 50px;
    }

    .filter-toggle {
      display: none;
      margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
      .filter-toggle {
        display: block;
      }

      .filter-column {
        position: fixed;
        top: 0;
        left: -100%;
        width: 80%;
        height: 100vh;
        background: white;
        z-index: 1050;
        padding: 2rem;
        transition: left 0.3s ease;
        overflow-y: auto;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
      }

      .filter-column.show {
        left: 0;
      }

      .filter-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
      }

      .filter-overlay.show {
        display: block;
      }

      .close-filter {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        background: none;
        border: none;
        color: #6c757d;
      }
    }

    .course-stats {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 1rem;
    }

    .loading-spinner {
      display: none;
      text-align: center;
      padding: 2rem;
    }

    .loading-spinner.active {
      display: block;
    }

    .spinner-border {
      width: 3rem;
      height: 3rem;
    }

    #btnlight {
      display: none;
    }

    .course-card:hover #btnlight {
      display: block;
    }

    .btn-light {
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .course-card:hover .btn-light {
      opacity: 1;
    }
  </style>
@endpush

@section('content')

  {{-- HERO SECTION --}}
  <section class="courses-hero">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
          <h1 class="display-5 fw-bold mb-3">Explore Our Courses</h1>
          <p class="lead mb-4">Discover the perfect course to advance your skills and career</p>
        </div>
      </div>
    </div>
  </section>

  {{-- SEARCH AND FILTER SECTION --}}
  <div class="container">
    <div class="search-section">
      <form id="searchForm" method="GET" action="{{ route('courses.course_index') }}">
        <div class="row g-3">
          {{-- Search Input --}}
          <div class="col-md-6">
            <div class="search-box">
              <i class="fas fa-search search-icon"></i>
              <input type="text" name="search" id="searchInput" class="form-control"
                placeholder="Search courses by title, instructor, or keywords..." value="{{ request('search') }}">
            </div>
          </div>

          {{-- Category Filter --}}
          <div class="col-md-3">
            <select class="select2 form-select" name="category" id="categorySelect">
              <option value="">All Categories</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Subcategory Filter --}}
          <div class="col-md-3">
            <select class="select2 form-select" name="subcategory" id="subcategorySelect">
              <option value="">All Subcategories</option>
              @if (isset($subcategories))
                @foreach ($subcategories as $subcategory)
                  <option value="{{ $subcategory->id }}"
                    {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                    {{ $subcategory->name }}
                  </option>
                @endforeach
              @endif
            </select>
          </div>

          {{-- Level Filter --}}
          <div class="col-md-3">
            <select class="form-select" name="level" id="levelSelect">
              <option value="">All Levels</option>
              <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
              <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Intermediate
              </option>
              <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
            </select>
          </div>

          {{-- Price Filter --}}
          <div class="col-md-3">
            <select class="form-select" name="price" id="priceSelect">
              <option value="">All Prices</option>
              <option value="free" {{ request('price') == 'free' ? 'selected' : '' }}>Free</option>
              <option value="paid" {{ request('price') == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
          </div>

          {{-- Sort By --}}
          <div class="col-md-3">
            <select class="form-select" name="sort" id="sortSelect">
              <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
              <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>

            </select>
          </div>

          {{-- Action Buttons --}}
          <div class="col-md-3">
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter me-2"></i>Apply Filters
              </button>
              <a href="{{ route('courses.course_index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-redo"></i>
              </a>
            </div>
          </div>
        </div>
      </form>

      {{-- Quick Category Tags --}}
      <div class="mt-4">
        <h6 class="mb-3">Popular Categories:</h6>
        <div class="category-tags">
          <span class="category-tag" data-category="all">All Courses</span>
          @foreach ($categories->take(8) as $category)
            <span class="category-tag" data-category="{{ $category->id }}">
              {{ $category->name }}
            </span>
          @endforeach
          @if ($categories->count() > 8)
            <span class="category-tag" data-bs-toggle="collapse" href="#moreCategories">
              More <i class="fas fa-chevron-down ms-1"></i>
            </span>
            <div class="collapse mt-2" id="moreCategories">
              <div class="category-tags">
                @foreach ($categories->skip(8) as $category)
                  <span class="category-tag" data-category="{{ $category->id }}">
                    {{ $category->name }}
                  </span>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- FILTER TOGGLE FOR MOBILE --}}
  <div class="filter-toggle container">
    <button class="btn btn-outline-primary w-100" id="toggleFilterBtn">
      <i class="fas fa-filter me-2"></i>Show Filters
    </button>
  </div>

  {{-- FILTER OVERLAY FOR MOBILE --}}
  <div class="filter-overlay" id="filterOverlay"></div>

  {{-- MAIN CONTENT --}}
  <div class="container my-5">
    <div class="row">
      {{-- COURSES COUNT --}}
      <div class="col-12 mb-4">
        <div class="course-stats">
          <div class="row align-items-center">
            <div class="col-md-6">
              <h5 class="mb-0">{{ $courses->total() }} courses found</h5>
              @if (request()->anyFilled(['search', 'category', 'subcategory', 'level', 'price']))
                <small class="text-muted">Filtered results</small>
              @endif
            </div>
            <div class="col-md-6 text-md-end">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="gridViewBtn">
                  <i class="fas fa-th"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="listViewBtn">
                  <i class="fas fa-list"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- COURSES GRID/LIST --}}
      <div class="col-12">
        {{-- Loading Spinner --}}
        <div class="loading-spinner" id="loadingSpinner">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="mt-3">Loading courses...</p>
        </div>

        {{-- Courses Display --}}
        <div id="coursesContainer">
          {{-- <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3" id="coursesGrid">
            @forelse ($courses as $course)
              <div class="col">
                <div class="card course-card">
                  <div class="position-relative">
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top"
                      alt="{{ $course->title }}">


                    <div class="card-img-overlay d-flex align-items-start justify-content-end">

                      <form action="{{ route('wishlist.add', $course->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-light btn-sm rounded-circle wishlist-btn" type="submit">
                          <i class="{{ in_array($course->id, $wishlistIds) ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                      </form>

                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <span class="badge bg-light text-dark">{{ $course->category->name }} >
                        {{ $course->subCategory->name }}</span>
                      <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <small>{{ $course->reviews_count }}</small>
                      </div>
                    </div>
                    <h5 class="card-title mb-2">{{ Str::limit($course->title, 50) }}</h5>
                    <p class="card-text text-muted mb-3">{!! Str::limit(strip_tags($course->description), 100) !!}</p>

                    <div class="course-meta mb-3">
                      <span class="me-3">
                        <i class="fas fa-user-graduate"></i>
                        {{ $course->enrollments_count }} students
                      </span>
                      <span class="me-3">
                        <i class="fas fa-clock"></i>
                        {{ $course->duration ?? 'N/A' }} hours
                      </span>
                      <span>
                        <i class="fas fa-eye"></i>
                        {{ $course->views }}Views
                      </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                      <div>

                        @if (!auth()->check() || !auth()->user()->canAccessCourse($course->id))
                          @if ($course->pricing && $course->pricing->price > 0)
                            <div class="course-price text-dark">
                              {{ $course->pricing->currency_symbol }}
                              {{ $course->pricing->price }}
                            </div>
                          @else
                            <div class="course-price text-dark">FREE</div>
                          @endif
                        @endif
                      </div>
                      <a href="{{ route('courses.course_show', $course->slug) }}" class="btn btn-primary btn-sm">

                        {{ auth()->check() && $course->is_enrolled && $course->canAccessEnrollment($course->id) ? 'Go to course' : 'View Course' }}

                      </a>

                      <!-- Hidden Add to Cart -->
                      <div class="cart-hover-btn">
                        <form action="{{ route('cart.add', $course->id) }}" method="POST">
                          @csrf
                          @if (in_array($course->id, $cartIds))
                            <button class="btn btn-success btn-sm" disabled>
                              <i class="fas fa-check me-1"></i> Added
                            </button>
                          @else
                            <button class="btn btn-primary btn-sm" type="submit">
                              <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                          @endif
                        </form>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="no-courses">
                  <i class="fas fa-book-open"></i>
                  <h4>No courses found</h4>
                  <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
                  <a href="{{ route('courses.course_index') }}" class="btn btn-primary">Clear Filters</a>
                </div>
              </div>
            @endforelse
          </div> --}}

          <div class="row g-4" id="coursesGrid">
            @forelse ($courses as $course)
              <div class="col-lg-4 col-md-6">
                <div class="card course-card h-100">
                  <div class="position-relative">
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top"
                      alt="{{ $course->title }}">
                    <div class="card-img-overlay d-flex align-items-start justify-content-end">
                      <form action="{{ route('wishlist.add', $course->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-light btn-sm rounded-circle wishlist-btn" type="submit">
                          <i class="{{ in_array($course->id, $wishlistIds) ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <span class="badge bg-light text-dark">{{ $course->category->name ?? 'General' }} >
                        {{ $course->subCategory->name ?? 'Misc' }}</span>
                      <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <small>{{ $course->reviews_avg_rating ?? 0 }}</small>
                      </div>
                    </div>
                    <h5 class="card-title mb-2">{{ Str::limit($course->title, 50) }}</h5>
                    <p class="card-text text-muted mb-3">{!! Str::limit(strip_tags($course->description), 100) !!}</p>

                    <div class="course-meta mb-3">
                      <span class="me-3">
                        <i class="fas fa-user-graduate"></i>
                        {{ $course->enrollments_count ?? 0 }} students
                      </span>
                      <span class="me-3">
                        <i class="fas fa-clock"></i>
                        {{ $course->duration ?? 'N/A' }} hours
                      </span>
                      <span>
                        <i class="fas fa-eye"></i>
                        {{ $course->views ?? 0 }} Views
                      </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        @if (!auth()->check() || !auth()->user()->canAccessCourse($course->id))
                          @if ($course->pricing && $course->pricing->price > 0)
                            <div class="course-price text-dark">
                              {{ $course->pricing->currency_symbol ?? '$' }}{{ $course->pricing->price }}
                            </div>
                          @else
                            <div class="course-price text-dark">FREE</div>
                          @endif
                        @endif
                      </div>
                      <a href="{{ route('courses.course_show', $course->slug) }}" class="btn btn-primary btn-sm">
                        {{ auth()->check() && ($course->is_enrolled ?? false) ? 'Go to course' : 'View Course' }}
                      </a>
                      <div class="cart-hover-btn">
                        <form action="{{ route('cart.add', $course->id) }}" method="POST">
                          @csrf
                          @if (in_array($course->id, $cartIds))
                            <button class="btn btn-success btn-sm" disabled>
                              <i class="fas fa-check me-1"></i> Added
                            </button>
                          @else
                            <button class="btn btn-primary btn-sm" type="submit">
                              <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                          @endif
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="no-courses">
                  <i class="fas fa-book-open"></i>
                  <h4>No courses found</h4>
                  <p class="text-muted">Check back soon for new courses.</p>
                </div>
              </div>
            @endforelse
          </div>
        </div>

        {{-- PAGINATION --}}
        {{-- @if ($courses->hasPages())
          <div class="col-12 d-flex justify-content-between mt-4">
            {{ $courses->links('pagination::bootstrap-5') }}
          </div>
        @endif --}}
      </div>
    </div>
  </div>


  @push('js')
    <script>
      $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
          placeholder: "Select category",
          allowClear: true
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Category tag click handler
        $('.category-tag').on('click', function(e) {
          e.preventDefault();
          const categoryId = $(this).data('category');

          if (categoryId === 'all') {
            window.location.href = "{{ route('courses.course_index') }}";
          } else {
            $('#categorySelect').val(categoryId).trigger('change');
            $('#searchForm').submit();
          }
        });

        // Subcategory dependency on category
        $('#categorySelect').on('change', function() {
          const categoryId = $(this).val();

          if (categoryId) {
            // Fetch subcategories via AJAX
            $.ajax({
              url: "{{ route('api.subcategories.byCategory') }}",
              method: 'GET',
              data: {
                category_id: categoryId
              },
              success: function(response) {
                $('#subcategorySelect').empty().append('<option value="">All Subcategories</option>');

                if (response.length > 0) {
                  $.each(response, function(index, subcategory) {
                    $('#subcategorySelect').append(
                      $('<option>', {
                        value: subcategory.id,
                        text: subcategory.name
                      })
                    );
                  });
                }
              }
            });
          } else {
            $('#subcategorySelect').empty().append('<option value="">All Subcategories</option>');
          }
        });

        // Mobile filter toggle
        $('#toggleFilterBtn').on('click', function() {
          $('.filter-column').addClass('show');
          $('#filterOverlay').addClass('show');
        });

        $('#filterOverlay').on('click', function() {
          $('.filter-column').removeClass('show');
          $(this).removeClass('show');
        });

        $('.close-filter').on('click', function() {
          $('.filter-column').removeClass('show');
          $('#filterOverlay').removeClass('show');
        });

        // Grid/List view toggle
        $('#gridViewBtn').on('click', function() {
          $(this).addClass('active');
          $('#listViewBtn').removeClass('active');
          $('#coursesGrid').removeClass('row-cols-1').addClass('row-cols-1 row-cols-md-2 row-cols-lg-3');
          $('.course-card').css('max-height', 'none');
        });

        $('#listViewBtn').on('click', function() {
          $(this).addClass('active');
          $('#gridViewBtn').removeClass('active');
          $('#coursesGrid').removeClass('row-cols-1 row-cols-md-2 row-cols-lg-3').addClass('row-cols-1');
          $('.course-card').css('max-height', '200px');
        });

        // Auto-submit form on filter change
        $('#levelSelect, #priceSelect, #sortSelect').on('change', function() {
          $('#searchForm').submit();
        });

        // Debounced search input
        let searchTimeout;
        $('#searchInput').on('keyup', function() {
          clearTimeout(searchTimeout);
          searchTimeout = setTimeout(() => {
            $('#searchForm').submit();
          }, 500);
        });

        // AJAX loading for pagination
        $(document).on('click', '.pagination a', function(e) {
          e.preventDefault();
          const url = $(this).attr('href');
          loadCourses(url);
        });

        function loadCourses(url) {
          $('#loadingSpinner').addClass('active');

          $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
              $('#coursesContainer').html($(response).find('#coursesContainer').html());
              $('#loadingSpinner').removeClass('active');
              window.history.pushState({}, '', url);
            },
            error: function() {
              $('#loadingSpinner').removeClass('active');
              alert('Error loading courses. Please try again.');
            }
          });
        }

        // Update URL with filters without page reload
        $('#searchForm').on('submit', function(e) {
          e.preventDefault();
          const formData = $(this).serialize();
          const url = "{{ route('courses.course_index') }}?" + formData;
          loadCourses(url);
        });

        // Set active category tag based on current filter
        const currentCategory = "{{ request('category') }}";
        if (currentCategory) {
          $(`.category-tag[data-category="${currentCategory}"]`).addClass('active');
        } else {
          $('.category-tag[data-category="all"]').addClass('active');
        }
      });
    </script>
  @endpush

@endsection
