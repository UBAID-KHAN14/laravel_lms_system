<!-- Professional Footer -->
<footer class="professional-footer">
  <div class="footer-wave">
    {{-- <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path
        d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
        fill="currentColor"></path>
    </svg> --}}
  </div>

  <div class="footer-main">
    <div class="container">
      <div class="footer-grid">
        <!-- Brand Column -->
        <div class="footer-col footer-brand">
          <div class="footer-logo-container">
            <!-- LOGO -->
            @if (empty($setting) || empty($setting->logo))
              <span>no-image</span>
            @else
              <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->site_name }}" class="footer-logo">
            @endif

            <div class="footer-brand-info">
              @if (empty($setting) || empty($setting->site_name))
                <span>no-name</span>
              @else
                <h3 class="footer-brand-name">{{ $setting->site_name }}</h3>
              @endif

              <p class="footer-tagline">Empowering Education Through Innovation</p>
            </div>
          </div>

          <p class="footer-description">
            We provide comprehensive educational resources, tools, and support to help students,
            educators, and institutions achieve academic excellence.
          </p>

          <!-- Newsletter Subscription -->
          <div class="footer-newsletter">
            <h4 class="newsletter-title">Stay Updated</h4>
            <p class="newsletter-subtitle">Subscribe to our newsletter for the latest updates</p>
            <form class="newsletter-form">
              <div class="input-group">
                <input type="email" class="form-control" placeholder="Enter your email" required>
                <button type="submit" class="btn-subscribe">
                  <i class="fa-solid fa-paper-plane"></i>
                </button>
              </div>
              <div class="form-check mt-2">
                <input type="checkbox" class="form-check-input" id="newsletterConsent">
                <label class="form-check-label" for="newsletterConsent">
                  I agree to receive educational updates
                </label>
              </div>
            </form>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-col">
          <h4 class="footer-title">Quick Links</h4>
          <ul class="footer-links">
            <li><a href="{{ route('home.index') }}"><i class="fa-solid fa-chevron-right"></i> Home</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> About Us</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Courses</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Admissions</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Online Tests</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Study Materials</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Career Counseling</a></li>
          </ul>
        </div>

        <!-- Resources -->
        <div class="footer-col">
          <h4 class="footer-title">Resources</h4>
          <ul class="footer-links">
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Past Papers</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Lecture Videos</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> E-Books</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Research Papers</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Study Guides</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Scholarships</a></li>
            <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Educational Software</a></li>
          </ul>
        </div>

        <!-- Contact Info -->

      </div>

      <!-- Social Media Links -->
      <div class="footer-social-section">
        <h4 class="social-title">Follow Us</h4>
        <div class="social-icons-container">
          @foreach ($socialLinks as $social)
            <a href="{{ $social->url }}" target="_blank" class="social-icon-link" title="{{ $social->name }}">
              <div class="social-icon-wrapper">
                <i class="{{ $social->icon_class }}"></i>
                <span class="social-tooltip">{{ $social->name }}</span>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <div class="container">
      <div class="footer-bottom-content">
        <div class="copyright">
          @if (empty($setting) || empty($setting->site_name))
            <span>no-name</span>
          @else
            <p>&copy; {{ date('Y') }} {{ $setting->site_name }}. All rights reserved.</p>
          @endif

        </div>

        <div class="footer-legal">
          <a href="{{ route('home.privacy_policy') }}">Privacy Policy</a>
          <a href="{{ route('home.terms_condition') }}">Terms of Service</a>
          <a href="#">Cookie Policy</a>
          <a href="#">Disclaimer</a>
        </div>

        <div class="footer-badges">
          <span class="security-badge">
            <i class="fa-solid fa-shield-check"></i> Secure Platform
          </span>
          <span class="ssl-badge">
            <i class="fa-solid fa-lock"></i> SSL Encrypted
          </span>
        </div>
      </div>
    </div>
  </div>
</footer>
