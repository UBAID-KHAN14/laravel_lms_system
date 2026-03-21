@extends('home.layouts.app')
@push('styles')
  <style>
    :root {
      --primary-color: #0B8E96;
      --primary-light: #E8F6F7;
      --primary-dark: #08747A;
      --accent-color: #FF6B6B;
      --text-color: #2D3436;
      --light-bg: #F8F9FA;
      --card-shadow: 0 10px 30px rgba(11, 142, 150, 0.1);
      --transition: all 0.3s ease;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      color: var(--text-color);
      line-height: 1.6;
      overflow-x: hidden;
    }
  </style>
@endpush

@section('content')
  <!-- Hero Section -->
  <section class="about-hero">
    <div class="container">
      <div class="hero-content">
        <span class="hero-badge"><i class="fas fa-rocket me-2"></i>Since 2018</span>
        <h1 class="display-4 fw-bold mb-4">Building Smarter Digital Solutions</h1>
        <p class="lead mb-0">We specialize in creating modern, secure, and user-friendly web applications that help
          organizations operate more efficiently and effectively.</p>
      </div>
    </div>
  </section>

  <!-- LMS Stats -->
  <section class="lms-stats">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-3 col-sm-6">
          <div class="stat-card fade-in">
            <div class="stat-number" data-count="250">0</div>
            <p class="h6 fw-bold">Educational Institutions</p>
            <small class="text-muted">Trusting our platform</small>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="stat-card fade-in">
            <div class="stat-number" data-count="500000">0</div>
            <p class="h6 fw-bold">Active Learners</p>
            <small class="text-muted">Engaged daily</small>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="stat-card fade-in">
            <div class="stat-number" data-count="98">0</div>
            <p class="h6 fw-bold">Satisfaction Rate</p>
            <small class="text-muted">From our clients</small>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="stat-card fade-in">
            <div class="stat-number" data-count="40">0</div>
            <p class="h6 fw-bold">Countries Served</p>
            <small class="text-muted">Global reach</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Mission -->
  <section class="py-5">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="section-title">
            <h2>Our Mission</h2>
          </div>
          <p class="lead mb-4">To democratize quality education by providing institutions with powerful, intuitive, and
            scalable Learning Management Systems that adapt to modern pedagogical needs.</p>
          <p>We believe technology should enhance learning, not complicate it. Our platforms are designed with both
            educators and learners in mind, creating seamless digital environments where knowledge thrives.</p>
          <div class="mt-4">
            <a href="#features" class="btn btn-primary-custom"
              style="background-color: var(--primary-color); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
              <i class="fas fa-play-circle me-2"></i>See Our Features
            </a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="feature-card fade-in">
            <div class="lms-icon-box">
              <i class="fas fa-bullseye"></i>
            </div>
            <h3 class="fw-bold mb-3">Why Choose Our LMS?</h3>
            <p>Built on years of educational research and technological expertise, our platform bridges the gap between
              traditional teaching methods and digital innovation.</p>
            <ul class="list-unstyled mt-4">
              <li class="d-flex align-items-center mb-3">
                <div class="me-3">
                  <i class="fas fa-check-circle text-success"></i>
                </div>
                <div>Pedagogy-first approach to digital learning</div>
              </li>
              <li class="d-flex align-items-center mb-3">
                <div class="me-3">
                  <i class="fas fa-check-circle text-success"></i>
                </div>
                <div>Accessibility compliant for all learners</div>
              </li>
              <li class="d-flex align-items-center">
                <div class="me-3">
                  <i class="fas fa-check-circle text-success"></i>
                </div>
                <div>Scalable solutions for institutions of all sizes</div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- LMS Features -->
  <section class="bg-light py-5" id="features">
    <div class="container">
      <div class="section-title text-center">
        <h2>Core LMS Features</h2>
      </div>
      <p class="lead mx-auto mb-5 text-center" style="max-width: 700px;">Comprehensive tools designed to streamline
        course management, enhance student engagement, and simplify administrative tasks.</p>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card fade-in">
            <div class="feature-icon">
              <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h4 class="fw-bold mb-3">Course Management</h4>
            <p>Intuitive tools for creating, organizing, and delivering courses with multimedia content, assessments,
              and interactive modules.</p>
            <ul class="list-unstyled mt-3">
              <li class="mb-2"><i class="fas fa-check primary-text me-2"></i>Drag & drop course builder</li>
              <li class="mb-2"><i class="fas fa-check primary-text me-2"></i>Multimedia content support</li>
              <li><i class="fas fa-check primary-text me-2"></i>Automated grading system</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card fade-in">
            <div class="feature-icon">
              <i class="fas fa-user-graduate"></i>
            </div>
            <h4 class="fw-bold mb-3">Student Engagement</h4>
            <p>Interactive learning tools including discussion forums, live sessions, gamification, and progress
              tracking to keep learners motivated.</p>
            <ul class="list-unstyled mt-3">
              <li class="mb-2"><i class="fas fa-check primary-text me-2"></i>Interactive discussion boards</li>
              <li class="mb-2"><i class="fas fa-check primary-text me-2"></i>Live virtual classrooms</li>
              <li><i class="fas fa-check primary-text me-2"></i>Gamification & badges</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card fade-in">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <h4 class="fw-bold mb-3">Analytics & Reporting</h4>
            <p>Comprehensive analytics dashboards providing insights into student performance, engagement metrics, and
              learning outcomes.</p>
            <ul class="list-unstyled mt-3">
              <li class="mb-2"><i class="fas fa-check primary-text me-2"></i>Real-time progress tracking</li>
              <li class="mb-2"><i class="fas fa-check primary-text me-2"></i>Customizable reports</li>
              <li><i class="fas fa-check primary-text me-2"></i>Predictive analytics</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Values -->
  <section class="py-5">
    <div class="container">
      <div class="section-title text-center">
        <h2>Our Educational Philosophy</h2>
      </div>

      <div class="row g-4">
        <div class="col-lg-6">
          <div class="value-item fade-in">
            <div class="value-icon">
              <i class="fas fa-user-friends"></i>
            </div>
            <div class="value-content">
              <h5>Learner-Centered Design</h5>
              <p>Every feature is designed with the student experience at its core, ensuring intuitive navigation and
                accessible learning pathways.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="value-item fade-in">
            <div class="value-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <div class="value-content">
              <h5>Data Privacy & Security</h5>
              <p>We implement enterprise-grade security to protect sensitive educational data and ensure compliance with
                global privacy standards.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="value-item fade-in">
            <div class="value-icon">
              <i class="fas fa-sync-alt"></i>
            </div>
            <div class="value-content">
              <h5>Continuous Innovation</h5>
              <p>Regular updates incorporating the latest educational technology trends and pedagogical research
                findings.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="value-item fade-in">
            <div class="value-icon">
              <i class="fas fa-globe-americas"></i>
            </div>
            <div class="value-content">
              <h5>Inclusive Learning</h5>
              <p>Platforms designed for diverse learning needs with accessibility features and multi-language support.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Journey -->
  <section class="bg-light py-5">
    <div class="container">
      <div class="section-title text-center">
        <h2>Our Evolution in EdTech</h2>
      </div>

      <div class="lms-timeline">
        <div class="timeline-item fade-in">
          <div class="timeline-year">2018</div>
          <div class="timeline-content">
            <h5>Foundation & First LMS</h5>
            <p>Launched our first Learning Management System focused on higher education institutions, serving 5
              universities with custom solutions.</p>
          </div>
        </div>
        <div class="timeline-item fade-in">
          <div class="timeline-year">2019</div>
          <div class="timeline-content">
            <h5>K-12 Expansion</h5>
            <p>Adapted our platform for K-12 schools with age-appropriate interfaces and parent-teacher communication
              modules.</p>
          </div>
        </div>
        <div class="timeline-item fade-in">
          <div class="timeline-year">2020</div>
          <div class="timeline-content">
            <h5>Remote Learning Response</h5>
            <p>Rapidly scaled to support 100+ institutions transitioning to remote learning during global challenges.
            </p>
          </div>
        </div>
        <div class="timeline-item fade-in">
          <div class="timeline-year">2022</div>
          <div class="timeline-content">
            <h5>AI Integration</h5>
            <p>Introduced AI-powered features including personalized learning paths, automated feedback, and predictive
              analytics.</p>
          </div>
        </div>
        <div class="timeline-item fade-in">
          <div class="timeline-year">2023</div>
          <div class="timeline-content">
            <h5>Global Expansion</h5>
            <p>Extended services to 40+ countries with multi-language support and region-specific educational
              frameworks.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Leadership Team -->
  <section class="py-5">
    <div class="container">
      <div class="section-title text-center">
        <h2>Our Education Technology Experts</h2>
      </div>
      <p class="lead mx-auto mb-5 text-center" style="max-width: 700px;">A diverse team of educators, technologists,
        and innovators committed to transforming learning experiences.</p>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="team-card fade-in">
            <div class="team-img">
              <i class="fas fa-user-tie"></i>
            </div>
            <div class="team-info">
              <h5 class="fw-bold mb-1">Dr. Sarah Chen</h5>
              <p class="text-muted mb-3">Chief Education Officer</p>
              <p class="small">Former university professor with 15+ years in educational technology research.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="team-card fade-in">
            <div class="team-img">
              <i class="fas fa-laptop-code"></i>
            </div>
            <div class="team-info">
              <h5 class="fw-bold mb-1">Michael Rodriguez</h5>
              <p class="text-muted mb-3">Lead Product Architect</p>
              <p class="small">Specializes in scalable educational platforms with 12+ years experience.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="team-card fade-in">
            <div class="team-img">
              <i class="fas fa-chart-pie"></i>
            </div>
            <div class="team-info">
              <h5 class="fw-bold mb-1">James Wilson</h5>
              <p class="text-muted mb-3">Head of Learning Analytics</p>
              <p class="small">Data scientist focused on educational outcomes and predictive modeling.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-5">
    <div class="container">
      <div class="lms-cta fade-in">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <h2 class="fw-bold mb-3">Ready to Transform Your Institution's Learning Experience?</h2>
            <p class="mb-0" style="opacity: 0.9;">Join 250+ educational institutions already using our platform to
              enhance teaching and learning outcomes.</p>
          </div>
          <div class="col-lg-4 text-lg-end mt-lg-0 mt-4">
            <a href="/contact" class="cta-btn">
              <i class="fas fa-calendar-check me-2"></i> Schedule a Demo
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  @push('js')
    <script src="{{ asset('js/custom.js') }}"></script>
  @endpush
@endsection
