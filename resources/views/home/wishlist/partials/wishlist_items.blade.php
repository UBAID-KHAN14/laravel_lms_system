@forelse ($wishlists as $wishlist)
  @php $course = $wishlist->course; @endphp
  <div class="col">
    <div class="card course-card">
      <div class="position-relative">
        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top" alt="{{ $course->title }}">


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
          <span class="">
            <i class="fas fa-user-graduate"></i>
            {{ $course->enrollments_count }} students
          </span>
          <span class="">
            <i class="fas fa-clock"></i>
            {{ $course->formattedDuration() ?? 'N/A' }} hours
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
      <a href="{{ route('wishlist.index') }}" class="btn btn-primary">Clear Filters</a>
    </div>
  </div>
@endforelse
