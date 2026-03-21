<header class="main-header">
  <div class="container-fluid">
    <div class="row align-items-center g-3">

      <!-- LOGO -->
      <div class="col-auto">
        @if (empty($setting) || empty($setting->logo))
          <span>no-image</span>
        @else
          <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="main-logo">
        @endif

      </div>

      <!-- SEARCH BAR -->
      <div class="col">
        <div class="search-wrapper">
          <i class="fa-solid fa-magnifying-glass search-icon"></i>
          <input type="text" class="search-input" placeholder="Search courses">
          <i class="fa-solid fa-xmark clear-icon"></i>
        </div>
      </div>

      <div class="d-none d-lg-block col-auto">
        <a href="{{ route('home.about_us') }}" class="business-link btn">About Us</a>
      </div>
      <div class="d-none d-lg-block col-auto">
        <a href="{{ route('home.contact_us') }}" class="business-link btn">Contact Us</a>
      </div>

      <!-- CATEGORIES -->
      <div class="category-hover col-auto" style="z-index: 9999">
        <a href="#" class="category-link">
          Categories <i class="fa-solid fa-chevron-down"></i>
        </a>

        <ul class="category-menu">
          @foreach ($categories as $category)
            <li class="category-item">
              <a href="{{ route('courses.course_index', ['category' => $category->id]) }}" class="category-link">
                {{ $category->name }}
              </a>

              @if ($category->subCategories->count())
                <ul class="subcategory-menu">
                  @foreach ($category->subCategories as $sub)
                    <li>
                      <a href="{{ route('courses.course_index', ['subcategory' => $sub->id]) }}">
                        {{ $sub->name }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ul>
      </div>


      <div class="d-none d-lg-block col-auto">
        <a href="{{ route('wishlist.index') }}"
          class="wishlist-link position-relative d-inline-flex align-items-center justify-content-center">
          <i class="fa-regular fa-heart wishlist-icon"></i>

          @if ($wishlistCount > 0)
            <span class="wishlist-badge">
              {{ $wishlistCount }}
            </span>
          @endif
        </a>
      </div>

      <div class="d-none d-lg-block col-auto">
        <a href="{{ route('cart.index') }}"
          class="cart-link position-relative d-inline-flex align-items-center justify-content-center"><i
            class="fas fa-cart-shopping cart-icon"></i>

          @if ($cartCount > 0)
            <span class="cart-badge">
              {{ $cartCount }}
            </span>
          @endif
        </a>
      </div>


      <!-- AUTH BUTTONS -->
      <div class="col-auto ms-auto">
        @if (Auth::check() && auth()->user()->is_active)
          <!-- User Dropdown -->
          <li class="nav-item dropdown user-dropdown" style="list-style-type: none;">
            <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              @if (auth()->user()->image)
                <div class="user-avatar-wrapper">
                  <img src="{{ asset('storage/' . auth()->user()->image) }}" class="user-avatar"
                    alt="{{ auth()->user()->name }}" width="45" height="45">
                  <span class="avatar-status bg-success"></span>
                </div>
              @else
                <div class="user-avatar-wrapper">
                  <div class="avatar-placeholder">
                    {{ substr(auth()->user()->name, 0, 1) }}
                  </div>
                  <span class="avatar-status bg-success"></span>
                </div>
              @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu border-0 shadow-lg"
              style="    z-index: 9999;">
              <!-- User Info -->
              <li class="dropdown-header border-bottom px-4 py-3">
                <div class="d-flex align-items-center">
                  @if (auth()->user()->image)
                    <img src="{{ asset('storage/' . auth()->user()->image) }}" class="dropdown-avatar me-3"
                      alt="{{ auth()->user()->name }}" width="45" height="45">
                  @else
                    <div class="avatar-placeholder dropdown-avatar me-3">
                      {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                  @endif
                  <div>
                    <h6 class="fw-semibold mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                    <div class="mt-1">
                      <span class="badge bg-primary rounded-pill px-2 py-1">
                        {{ ucfirst(auth()->user()->role) }}
                      </span>
                    </div>
                  </div>
                </div>
              </li>




              <!-- Role-based Dashboard -->
              @if (auth()->user()->role === 'admin')
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <div class="dropdown-icon">
                      <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <div>
                      <span>Admin Dashboard</span>
                      <small class="text-muted d-block">Manage system</small>
                    </div>
                  </a>
                </li>
              @elseif(auth()->user()->role === 'teacher')
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('teacher.dashboard') }}">
                    <div class="dropdown-icon">
                      <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div>
                      <span>Teacher Dashboard</span>
                      <small class="text-muted d-block">Manage classes</small>
                    </div>
                  </a>
                </li>
              @elseif(auth()->user()->role === 'student')
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('student.dashboard') }}">
                    <div class="dropdown-icon">
                      <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                      <span>Student Dashboard</span>
                      <small class="text-muted d-block">View courses</small>
                    </div>
                  </a>
                </li>
              @endif

              <!-- Divider -->
              <li>
                <hr class="dropdown-divider mx-3">
              </li>

              <!-- Settings -->
              {{-- <li>
                <a class="dropdown-item d-flex align-items-center" href="">
                  <div class="dropdown-icon">
                    <i class="fas fa-cog"></i>
                  </div>
                  <div>
                    <span>Settings</span>
                    <small class="text-muted d-block">Account settings</small>
                  </div>
                </a>
              </li> --}}

              <!-- Help -->
              {{-- <li>
                <a class="dropdown-item d-flex align-items-center" href="">
                  <div class="dropdown-icon">
                    <i class="fas fa-question-circle"></i>
                  </div>
                  <div>
                    <span>Help & Support</span>
                    <small class="text-muted d-block">Get help</small>
                  </div>
                </a>
              </li> --}}

              <!-- Divider -->
              {{-- <li>
                <hr class="dropdown-divider mx-3">
              </li> --}}

              <!-- Logout -->
              <li>
                <form method="POST" action="{{ route('logout') }}" class="w-100">
                  @csrf
                  <button type="submit" class="dropdown-item d-flex align-items-center text-danger w-100">
                    <div class="dropdown-icon">
                      <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div>
                      <span>Logout</span>
                      <small class="text-muted d-block">Sign out from account</small>
                    </div>
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <div class="auth-buttons">
            <a href="{{ route('login') }}" class="btn login me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-dark">Sign Up</a>
          </div>
        @endif

      </div>


    </div>
  </div>
</header>
