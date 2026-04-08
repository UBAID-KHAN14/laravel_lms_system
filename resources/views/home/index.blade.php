@extends('home.layouts.app')

@push('styles')
  <!-- Google Fonts, Swiper CSS, AOS -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}

  <style>
    :root {
      --primary-color: #0B8E96;
      --primary-light: #E8F6F7;
      --primary-dark: #08747A;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --bg-light: #f8fafc;
      --white: #ffffff;
      --shadow-sm: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
      --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
      font-family: 'Inter', sans-serif;
      color: var(--text-dark);
      background-color: var(--bg-light);
      overflow-x: hidden;
      scroll-behavior: smooth;
    }

    /* ========== MODERN SWIPER SLIDER ========== */
    .hero-swiper {
      width: 100%;
      height: 85vh;
      min-height: 600px;
      position: relative;
    }

    .swiper-slide {
      position: relative;
      overflow: hidden;
    }

    .slide-bg {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      transform: scale(1);
      transition: transform 6s ease-out;
    }

    .swiper-slide-active .slide-bg {
      transform: scale(1.05);
    }

    .slide-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0.4) 100%);
      z-index: 1;
    }

    .slide-content {
      position: absolute;
      bottom: 30%;
      left: 0;
      right: 0;
      text-align: center;
      z-index: 2;
      padding: 0 1.5rem;
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease 0.3s, transform 0.8s ease 0.3s;
    }

    .swiper-slide-active .slide-content {
      opacity: 1;
      transform: translateY(0);
    }

    .slide-content h1 {
      font-size: 3.5rem;
      font-weight: 800;
      color: white;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      margin-bottom: 1rem;
    }

    .slide-content p {
      font-size: 1.25rem;
      color: rgba(255, 255, 255, 0.95);
      max-width: 700px;
      margin: 0 auto 1.8rem;
      font-weight: 500;
    }

    .btn-slider {
      background: var(--primary-color);
      color: white;
      padding: 12px 32px;
      border-radius: 40px;
      font-weight: 600;
      transition: var(--transition);
      border: none;
      box-shadow: 0 4px 12px rgba(11, 142, 150, 0.3);
    }

    .btn-slider:hover {
      background: var(--primary-dark);
      transform: translateY(-3px);
      box-shadow: 0 12px 20px rgba(11, 142, 150, 0.4);
      color: white;
    }

    .swiper-button-next,
    .swiper-button-prev {
      color: white;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(8px);
      width: 48px;
      height: 48px;
      border-radius: 50%;
      transition: var(--transition);
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
      background: var(--primary-color);
      transform: scale(1.05);
    }

    .swiper-pagination-bullet {
      background: white;
      opacity: 0.7;
      width: 10px;
      height: 10px;
    }

    .swiper-pagination-bullet-active {
      background: var(--primary-color);
      width: 26px;
      border-radius: 10px;
      opacity: 1;
    }


    /* ========== VALUE SECTION (your design) ========== */
    .theme-bg {
      background-color: #0B8E96;
    }

    .theme-text {
      color: #0B8E96;
    }

    .theme-border {
      border-color: #0B8E96;
    }

    .theme-btn {
      background: #0B8E96;
      transition: all 0.25s ease;
    }

    .theme-btn:hover {
      background: #09727a;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(11, 142, 150, 0.3);
    }

    /* value section container */
    .value-section {
      max-width: 1280px;
      margin: 0 auto;
      padding: 5rem 2rem;
      position: relative;
      overflow: hidden;
    }

    /* subtle background wave / accent (optional) */
    .value-bg-accent {
      position: absolute;
      top: 0;
      right: 0;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(11, 142, 150, 0.05) 0%, rgba(11, 142, 150, 0) 70%);
      border-radius: 50%;
      pointer-events: none;
      z-index: 0;
    }

    .value-bg-accent-left {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 250px;
      height: 250px;
      background: radial-gradient(circle, rgba(11, 142, 150, 0.03) 0%, rgba(11, 142, 150, 0) 70%);
      border-radius: 50%;
      pointer-events: none;
      z-index: 0;
    }

    /* main grid layout */
    .value-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      align-items: center;
      position: relative;
      z-index: 2;
    }

    /* left side: text + explanation */
    .value-content h2 {
      font-size: 2.8rem;
      font-weight: 800;
      line-height: 1.2;
      letter-spacing: -0.02em;
      background: linear-gradient(135deg, #0B8E96 0%, #126e7a 100%);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      margin-bottom: 1.5rem;
    }

    .value-badge {
      display: inline-block;
      background: rgba(11, 142, 150, 0.12);
      padding: 0.35rem 1rem;
      border-radius: 40px;
      font-size: 0.85rem;
      font-weight: 600;
      color: #0B8E96;
      margin-bottom: 1.2rem;
      letter-spacing: 0.3px;
    }

    .value-description {
      font-size: 1.2rem;
      line-height: 1.5;
      color: #2c3e44;
      margin-bottom: 2rem;
      font-weight: 400;
      max-width: 90%;
    }

    .feature-list {
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
      margin-bottom: 2rem;
    }

    .feature-item {
      display: flex;
      align-items: center;
      gap: 0.9rem;
    }

    .feature-icon {
      width: 44px;
      height: 44px;
      background: rgba(11, 142, 150, 0.1);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      color: #0B8E96;
      transition: transform 0.2s ease;
    }

    .feature-text h4 {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 0.2rem;
      color: #0f2c33;
    }

    .feature-text p {
      font-size: 0.95rem;
      color: #4a5b63;
      line-height: 1.4;
    }

    .cta-link {
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      font-weight: 600;
      color: #0B8E96;
      text-decoration: none;
      font-size: 1rem;
      border-bottom: 2px solid rgba(11, 142, 150, 0.3);
      transition: all 0.25s;
      padding-bottom: 4px;
    }

    .cta-link i {
      transition: transform 0.2s;
    }

    .cta-link:hover {
      color: #09727a;
      border-bottom-color: #0B8E96;
      gap: 0.8rem;
    }

    .cta-link:hover i {
      transform: translateX(4px);
    }

    /* right side: stats / illustrative card */
    .value-stats {
      background: #ffffff;
      border-radius: 2rem;
      box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.02);
      padding: 2rem 1.8rem;
      border: 1px solid rgba(11, 142, 150, 0.2);
      transition: all 0.3s;
    }

    .stat-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.8rem;
      margin-bottom: 2rem;
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      font-size: 2.4rem;
      font-weight: 800;
      color: #0B8E96;
      line-height: 1;
      margin-bottom: 0.5rem;
    }

    .stat-label {
      font-size: 0.85rem;
      font-weight: 500;
      color: #4a6572;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .highlight-card {
      background: linear-gradient(135deg, #F8FBFE 0%, #F0F7F9 100%);
      border-radius: 1.2rem;
      padding: 1.2rem;
      margin-top: 0.8rem;
      border-left: 4px solid #0B8E96;
    }

    .highlight-card p {
      font-size: 0.95rem;
      font-weight: 500;
      color: #1c3b44;
      line-height: 1.5;
    }

    .highlight-card i {
      color: #0B8E96;
      margin-right: 6px;
    }

    /* responsiveness */
    @media (max-width: 900px) {
      .value-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .value-content h2 {
        font-size: 2.2rem;
      }

      .value-description {
        max-width: 100%;
        font-size: 1rem;
      }

      .value-section {
        padding: 3rem 1.5rem;
      }
    }

    @media (max-width: 480px) {
      .stat-grid {
        gap: 1rem;
      }

      .stat-number {
        font-size: 1.8rem;
      }
    }

    /* custom AOS duration override */
    [data-aos] {
      transition-timing-function: cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }


    /* ========== TRUST SECTION ========== */
    .stats-section-wrapper {
      max-width: 1280px;
      margin: 0 auto;
      padding: 3rem 2rem 4rem 2rem;
    }

    /* main stats card with modern glassmorphism / soft shadow */
    .trust-stats-container {
      background: #ffffff;
      border-radius: 2rem;
      box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.02);
      border: 1px solid rgba(11, 142, 150, 0.15);
      padding: 2.5rem 1.5rem;
      transition: all 0.2s ease;
    }

    /* optional headline / mini tagline above stats */
    .stats-headline {
      text-align: center;
      margin-bottom: 2.5rem;
    }

    .stats-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(11, 142, 150, 0.08);
      padding: 0.3rem 1rem;
      border-radius: 40px;
      font-size: 0.8rem;
      font-weight: 600;
      color: #0B8E96;
      letter-spacing: 0.3px;
      margin-bottom: 1rem;
    }

    .stats-headline h2 {
      font-size: 2rem;
      font-weight: 800;
      color: #0f2e38;
      letter-spacing: -0.01em;
    }

    .stats-headline h2 span {
      background: linear-gradient(135deg, #0B8E96 0%, #0f6f78 100%);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }

    .stats-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 2rem;
      text-align: center;
    }

    /* each stat card */
    .stat-card {
      flex: 1;
      min-width: 160px;
      padding: 1rem 0.5rem;
      transition: transform 0.25s ease;
      border-radius: 1.5rem;
      background: #ffffff;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    /* icon circle with theme color */
    .stat-icon {
      width: 70px;
      height: 70px;
      background: rgba(11, 142, 150, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem auto;
      font-size: 2rem;
      color: #0B8E96;
      transition: all 0.2s;
    }

    .stat-card:hover .stat-icon {
      background: rgba(11, 142, 150, 0.2);
      transform: scale(1.02);
    }

    /* counter number style */
    .stat-number {
      font-size: 2.8rem;
      font-weight: 800;
      color: #0B8E96;
      line-height: 1.1;
      margin-bottom: 0.35rem;
      letter-spacing: -0.02em;
    }

    .stat-label {
      font-size: 1rem;
      font-weight: 600;
      color: #2c5563;
      margin-bottom: 0.2rem;
    }

    .stat-sub {
      font-size: 0.75rem;
      color: #6f8f9c;
      font-weight: 400;
    }

    /* divider line (optional decorative) */
    .stats-divider {
      width: 1px;
      height: 60px;
      background: rgba(11, 142, 150, 0.2);
    }

    /* responsive */
    @media (max-width: 750px) {
      .stats-grid {
        flex-direction: column;
        gap: 1.5rem;
      }

      .stat-card {
        width: 100%;
        border-bottom: 1px solid rgba(11, 142, 150, 0.1);
        padding-bottom: 1.2rem;
      }

      .stat-card:last-child {
        border-bottom: none;
      }

      .stats-divider {
        display: none;
      }

      .stat-number {
        font-size: 2.2rem;
      }

      .stats-headline h2 {
        font-size: 1.7rem;
      }
    }

    /* counter animation classes (used by JS) */
    .count-up {
      display: inline-block;
    }

    /* button or extra CTA after stats (optional but adds trust) */
    .trust-footer {
      text-align: center;
      margin-top: 2rem;
      font-size: 0.85rem;
      color: #4a6e7c;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .trust-footer i {
      color: #0B8E96;
    }


    /* ========== COURSE CARD (exactly from your course listing) ========== */
    .section-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .section-header .badge {
      background: var(--primary-light);
      color: var(--primary-dark);
      padding: 6px 18px;
      border-radius: 40px;
      font-weight: 600;
      font-size: 0.85rem;
      display: inline-block;
      margin-bottom: 1rem;
    }

    .section-header h2 {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 1rem;
    }

    .course-card {
      border: none;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      height: 100%;
      background: var(--white);
    }

    .course-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow-lg);
    }

    .course-card img {
      height: 160px;
      object-fit: cover;
      width: 100%;
    }

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

    .wishlist-btn {
      background: white;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #e74c3c;
      transition: var(--transition);
      border: none;
    }

    .wishlist-btn:hover {
      background: #e74c3c;
      color: white;
      transform: scale(1.05);
    }

    .course-card .card-body {
      padding: 1.2rem;
    }

    .course-card .badge.bg-light {
      background: #f1f5f9 !important;
      color: var(--text-dark);
      font-size: 0.7rem;
    }

    .course-card .card-title {
      font-size: 1rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      line-height: 1.3;
    }

    .course-card .card-text {
      font-size: 0.8rem;
      color: var(--text-muted);
      margin-bottom: 0.8rem;
    }

    .course-meta {
      font-size: 0.75rem;
      color: var(--text-muted);
      margin-bottom: 0.8rem;
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .course-meta i {
      margin-right: 0.2rem;
      color: var(--primary-color);
    }

    .course-price {
      font-weight: 800;
      font-size: 1.1rem;
      color: var(--primary-color);
    }

    .btn-primary {
      background-color: var(--primary-color);
      border: none;
      padding: 0.4rem 1rem;
      font-size: 0.8rem;
      border-radius: 30px;
      transition: var(--transition);
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
    }

    .cart-hover-btn form {
      display: inline-block;
    }

    .btn-success {
      background-color: #28a745;
      font-size: 0.75rem;
    }





    /* ========== DEMO SECTION ========== */
    .demo-section-wrapper {
      max-width: 1280px;
      margin: 0 auto;
      padding: 3rem 2rem 5rem 2rem;
    }

    /* SECTION STYLES (live preview / demo) */
    .live-demo-section {
      background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
      border-radius: 2.5rem;
      box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.08), 0 2px 10px rgba(0, 0, 0, 0.02);
      overflow: hidden;
      transition: transform 0.3s ease;
      border: 1px solid rgba(11, 142, 150, 0.2);
    }

    .demo-grid {
      display: flex;
      flex-wrap: wrap;
      align-items: stretch;
    }

    /* video / media preview side */
    .demo-media {
      flex: 1.2;
      min-width: 280px;
      background: #0a1e24;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .video-container {
      width: 100%;
      border-radius: 1.5rem;
      overflow: hidden;
      box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.25);
      transition: all 0.3s;
      background: #00000010;
    }

    .demo-video {
      width: 100%;
      display: block;
      aspect-ratio: 16 / 9;
      object-fit: cover;
      background: #0f2c2f;
      cursor: pointer;
    }

    /* custom play overlay (just for aesthetic, but video works) */
    .video-wrapper {
      position: relative;
    }

    /* right side content */
    .demo-content {
      flex: 1;
      padding: 2.5rem 2rem;
      background: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .demo-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(11, 142, 150, 0.1);
      padding: 0.35rem 1rem;
      border-radius: 40px;
      width: fit-content;
      font-size: 0.8rem;
      font-weight: 600;
      color: #0B8E96;
      margin-bottom: 1.2rem;
      letter-spacing: 0.3px;
    }

    .demo-badge i {
      font-size: 0.85rem;
    }

    .demo-content h3 {
      font-size: 2rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, #0B8E96 0%, #0c6c73 100%);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }

    .demo-description {
      font-size: 1rem;
      color: #2c4a57;
      margin-bottom: 1.8rem;
      max-width: 90%;
    }

    .demo-feature-list {
      list-style: none;
      margin-bottom: 2rem;
    }

    .demo-feature-list li {
      display: flex;
      align-items: center;
      gap: 0.7rem;
      margin-bottom: 0.8rem;
      font-size: 0.95rem;
      color: #1f3e48;
    }

    .demo-feature-list li i {
      color: #0B8E96;
      font-size: 1.1rem;
      width: 24px;
    }

    /* MAIN CTA BUTTON - View Demo */
    .btn-demo {
      display: inline-flex;
      align-items: center;
      gap: 0.75rem;
      background: #0B8E96;
      color: white;
      font-weight: 600;
      font-size: 1rem;
      padding: 0.9rem 2rem;
      border-radius: 60px;
      text-decoration: none;
      transition: all 0.25s ease;
      border: none;
      cursor: pointer;
      width: fit-content;
      box-shadow: 0 6px 14px rgba(11, 142, 150, 0.3);
      letter-spacing: 0.3px;
    }

    .btn-demo i {
      font-size: 1.1rem;
      transition: transform 0.2s;
    }

    .btn-demo:hover {
      background: #09727a;
      transform: translateY(-2px);
      box-shadow: 0 12px 22px rgba(11, 142, 150, 0.35);
      gap: 0.9rem;
    }

    .btn-demo:hover i {
      transform: translateX(4px);
    }

    /* small text note */
    .demo-note {
      margin-top: 1.2rem;
      font-size: 0.75rem;
      color: #6b8b9a;
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }

    /* responsive */
    @media (max-width: 850px) {
      .demo-grid {
        flex-direction: column;
      }

      .demo-media {
        padding: 1.5rem;
      }

      .demo-content {
        padding: 2rem 1.5rem;
      }

      .demo-content h3 {
        font-size: 1.8rem;
      }

      .demo-description {
        max-width: 100%;
      }
    }

    @media (max-width: 480px) {
      .demo-section-wrapper {
        padding: 1.5rem 1rem 3rem 1rem;
      }

      .btn-demo {
        padding: 0.7rem 1.5rem;
        font-size: 0.9rem;
      }
    }

    /* video placeholder overlay (optional, but video is functional) */
    .video-container video {
      width: 100%;
      height: auto;
      display: block;
      border-radius: 1rem;
    }

    /* simple animation on scroll (AOS ready but not needed for the snippet) */
    [data-aos="fade-right"] {
      transition: transform 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1), opacity 0.6s ease;
    }



    /* ========== TESTIMONIALS SECTION ========== */
    .testimonials-wrapper {
      max-width: 1280px;
      margin: 0 auto;
      padding: 4rem 2rem 5rem 2rem;
    }

    /* section header */
    .testimonials-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .testimonials-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(11, 142, 150, 0.08);
      padding: 0.3rem 1rem;
      border-radius: 40px;
      font-size: 0.8rem;
      font-weight: 600;
      color: #0B8E96;
      letter-spacing: 0.3px;
      margin-bottom: 1rem;
    }

    .testimonials-header h2 {
      font-size: 2rem;
      font-weight: 800;
      color: #0f2e38;
      letter-spacing: -0.01em;
    }

    .testimonials-header h2 span {
      background: linear-gradient(135deg, #0B8E96 0%, #0f6f78 100%);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }

    .testimonials-sub {
      color: #4a6e7c;
      font-size: 1rem;
      margin-top: 0.5rem;
      max-width: 550px;
      margin-left: auto;
      margin-right: auto;
    }

    /* testimonials grid — 3 cards */
    .testimonials-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: center;
      margin-top: 1rem;
    }

    .testimonial-card {
      flex: 1;
      min-width: 280px;
      max-width: 380px;
      background: #ffffff;
      border-radius: 1.5rem;
      padding: 1.8rem;
      box-shadow: 0 15px 30px -12px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(11, 142, 150, 0.12);
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      display: flex;
      flex-direction: column;
    }

    .testimonial-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 25px 40px -14px rgba(11, 142, 150, 0.18);
      border-color: rgba(11, 142, 150, 0.25);
    }

    /* quote icon */
    .quote-icon {
      font-size: 2rem;
      color: rgba(11, 142, 150, 0.3);
      margin-bottom: 1rem;
      line-height: 1;
    }

    .testimonial-text {
      font-size: 1rem;
      line-height: 1.5;
      color: #2c4a57;
      margin-bottom: 1.5rem;
      font-weight: 400;
      flex: 1;
    }

    /* rating stars */
    .rating {
      margin-bottom: 1.2rem;
      display: flex;
      gap: 0.2rem;
      color: #ffb83b;
      font-size: 0.9rem;
    }

    .rating i {
      margin-right: 2px;
    }

    /* author section */
    .author {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      border-top: 1px solid rgba(11, 142, 150, 0.1);
      padding-top: 1.2rem;
      margin-top: auto;
    }

    .avatar {
      width: 48px;
      height: 48px;
      background: #eef2f5;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      color: #0B8E96;
      background: rgba(11, 142, 150, 0.12);
      font-size: 1.1rem;
    }

    .author-info h4 {
      font-size: 1rem;
      font-weight: 700;
      color: #1a3b45;
    }

    .author-info p {
      font-size: 0.75rem;
      color: #6f8f9c;
      margin-top: 0.15rem;
    }

    /* optional trust badge at the bottom */
    .trust-badge {
      text-align: center;
      margin-top: 3rem;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1.5rem;
      align-items: center;
      font-size: 0.8rem;
      color: #4f7e8c;
      background: rgba(11, 142, 150, 0.03);
      padding: 1rem 1.5rem;
      border-radius: 60px;
      width: fit-content;
      margin-left: auto;
      margin-right: auto;
    }

    .trust-badge i {
      color: #0B8E96;
      margin-right: 0.3rem;
    }

    /* responsiveness */
    @media (max-width: 750px) {
      .testimonials-wrapper {
        padding: 2rem 1.2rem 3rem 1.2rem;
      }

      .testimonials-header h2 {
        font-size: 1.7rem;
      }

      .testimonial-card {
        min-width: 260px;
      }
    }


    /* ========== CONTACT SECTION (your design) ========== */
    .contact-section {
      background: linear-gradient(135deg, #f0f9fa 0%, #ffffff 100%);
      border-radius: 2rem;
      padding: 3rem 2rem;
      margin-top: 3rem;
    }

    .card-contact {
      background: var(--white);
      border-radius: 2rem;
      box-shadow: var(--shadow-md);
      transition: var(--transition);
      border: none;
      height: 100%;
    }

    .card-contact:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }

    .contact-icon {
      width: 70px;
      height: 70px;
      background: var(--primary-light);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.2rem;
    }

    .contact-icon i {
      font-size: 2rem;
      color: var(--primary-color);
    }

    .info-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      margin-bottom: 1.8rem;
      transition: transform 0.2s ease;
    }

    .info-item:hover {
      transform: translateX(8px);
    }

    .info-icon {
      width: 44px;
      height: 44px;
      background: var(--primary-light);
      border-radius: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .info-icon i {
      font-size: 1.2rem;
      color: var(--primary-color);
    }

    .social-links {
      display: flex;
      gap: 12px;
      margin-top: 12px;
    }

    .social-icon {
      width: 40px;
      height: 40px;
      background: var(--primary-light);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-color);
      transition: var(--transition);
    }

    .social-icon:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-3px);
    }

    .floating-label {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .floating-label input,
    .floating-label textarea {
      width: 100%;
      padding: 1rem 1rem 0.5rem 1rem;
      border: 1px solid #e2e8f0;
      border-radius: 1rem;
      background: white;
      transition: var(--transition);
      font-size: 1rem;
    }

    .floating-label input:focus,
    .floating-label textarea:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(11, 142, 150, 0.2);
      outline: none;
    }

    .floating-label label {
      position: absolute;
      left: 1rem;
      top: 0.9rem;
      transition: 0.2s ease;
      color: #94a3b8;
      pointer-events: none;
    }

    .floating-label input:focus~label,
    .floating-label input:not(:placeholder-shown)~label,
    .floating-label textarea:focus~label,
    .floating-label textarea:not(:placeholder-shown)~label {
      top: 0.2rem;
      font-size: 0.7rem;
      color: var(--primary-color);
      background: white;
      padding: 0 5px;
    }

    .btn-primary-custom {
      background: var(--primary-color);
      border: none;
      padding: 12px 28px;
      border-radius: 50px;
      font-weight: 700;
      transition: var(--transition);
      color: white;
      width: 100%;
    }

    .btn-primary-custom:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(11, 142, 150, 0.3);
    }

    .invalid-feedback {
      font-size: 0.75rem;
      margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
      .hero-swiper {
        height: 60vh;
        min-height: 450px;
      }

      .slide-content h1 {
        font-size: 2rem;
      }

      .slide-content p {
        font-size: 1rem;
      }

      .section-header h2 {
        font-size: 1.8rem;
      }
    }
  </style>
@endpush

@section('content')
  {{-- ==================== 1. MODERN SLIDER (Swiper) ==================== --}}
  <div class="hero-swiper swiper">
    <div class="swiper-wrapper">
      @php
        $sliderItems = [];
        if (isset($sliders) && $sliders->count() > 0) {
            foreach ($sliders as $slider) {
                $sliderItems[] = [
                    'image' => asset('storage/' . $slider->image),
                    'title' => $slider->title,
                    'description' => $slider->description,
                    'btn_text' => 'Get Now',
                    'btn_link' => '#courses',
                ];
            }
        } else {
            $sliderItems = [
                [
                    'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070',
                    'title' => 'Master New Skills With AI',
                    'description' => 'Personalized learning paths powered by next‑gen AI. Start your journey today.',
                    'btn_text' => 'Explore Courses',
                    'btn_link' => '#courses',
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070',
                    'title' => 'Learn From Industry Experts',
                    'description' => 'Real‑world projects and mentorship from top professionals.',
                    'btn_text' => 'Join Now',
                    'btn_link' => '#courses',
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070',
                    'title' => 'Future-Ready Certification',
                    'description' => 'Earn globally recognized certificates and boost your career.',
                    'btn_text' => 'Get Started',
                    'btn_link' => '#courses',
                ],
            ];
        }
      @endphp
      @foreach ($sliderItems as $slide)
        <div class="swiper-slide">
          <img src="{{ $slide['image'] }}" class="slide-bg" alt="Slide">
          <div class="slide-overlay"></div>
          <div class="slide-content">
            <h1 data-aos="fade-up">{{ $slide['title'] }}</h1>
            <p data-aos="fade-up" data-aos-delay="150">{!! $slide['description'] !!}</p>
            <a href="{{ $slide['btn_link'] }}" class="btn btn-slider" data-aos="fade-up"
              data-aos-delay="300">{{ $slide['btn_text'] }}</a>
          </div>
        </div>
      @endforeach
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>


  {{-- ========== 2. VALUE SECTION  ========== --}}
  <section class="value-section" id="valueSection">
    <!-- subtle background accents for flair -->
    <div class="value-bg-accent"></div>
    <div class="value-bg-accent-left"></div>

    <div class="value-grid">
      <!-- LEFT: Core explanation + features (AOS) -->
      <div class="value-content" data-aos="fade-up" data-aos-duration="800" data-aos-offset="100">
        <div class="value-badge">
          <i class="fas fa-graduation-cap" style="margin-right: 6px;"></i> Next-Gen Learning Ecosystem
        </div>
        <h2>
          Transform knowledge into <span class="theme-text">real growth</span>
        </h2>
        <div class="value-description">
          Your all-in-one LMS that goes beyond hosting courses. We empower educators, engage learners, and simplify
          administration — from interactive lessons to smart progress analytics.
        </div>

        <div class="feature-list">
          <div class="feature-item" data-aos="fade-right" data-aos-duration="600" data-aos-delay="100">
            <div class="feature-icon">
              <i class="fas fa-chalkboard-user"></i>
            </div>
            <div class="feature-text">
              <h4>Intelligent course delivery</h4>
              <p>Adaptive learning paths, quizzes, and multimedia lessons that keep students motivated.</p>
            </div>
          </div>
          <div class="feature-item" data-aos="fade-right" data-aos-duration="600" data-aos-delay="200">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="feature-text">
              <h4>Real-time performance insights</h4>
              <p>Dashboards with engagement metrics, completion rates, and personalized feedback.</p>
            </div>
          </div>
          <div class="feature-item" data-aos="fade-right" data-aos-duration="600" data-aos-delay="300">
            <div class="feature-icon">
              <i class="fas fa-users-between"></i>
            </div>
            <div class="feature-text">
              <h4>Collaboration & community</h4>
              <p>Discussion forums, group assignments, and live sessions to foster peer learning.</p>
            </div>
          </div>
        </div>

        <a href="#" class="cta-link" data-aos="zoom-in" data-aos-delay="400">
          Explore all features <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <!-- RIGHT: visual stats + testimonial vibe (AOS) -->
      <div class="value-stats" data-aos="fade-left" data-aos-duration="800" data-aos-offset="100">
        <div class="stat-grid">
          <div class="stat-item" data-aos="flip-up" data-aos-delay="100">
            <div class="stat-number">98%</div>
            <div class="stat-label">learner satisfaction</div>
          </div>
          <div class="stat-item" data-aos="flip-up" data-aos-delay="200">
            <div class="stat-number">150+</div>
            <div class="stat-label">expert instructors</div>
          </div>
          <div class="stat-item" data-aos="flip-up" data-aos-delay="300">
            <div class="stat-number">4.9⭐</div>
            <div class="stat-label">average rating</div>
          </div>
          <div class="stat-item" data-aos="flip-up" data-aos-delay="400">
            <div class="stat-number">12k+</div>
            <div class="stat-label">active courses</div>
          </div>
        </div>
        <div class="highlight-card" data-aos="fade-up" data-aos-delay="200">
          <p><i class="fas fa-quote-left"></i> “The most intuitive LMS I've ever used — from content creation to student
            progress tracking, everything flows seamlessly.”</p>
          <p style="margin-top: 8px; font-size: 0.8rem; font-weight: 600;">— Dr. Sarah Chen, Lead Educator</p>
        </div>
        <div style="margin-top: 1.5rem; text-align: center;" data-aos="fade-up" data-aos-delay="250">
          <span
            style="background: #0B8E9610; padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.75rem; font-weight: 500; color: #0B8E96;"><i
              class="fas fa-check-circle"></i> Trusted by 500+ institutions</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== 3. STATS / TRUST SECTION ========== -->
  <div class="stats-section-wrapper">
    <div class="trust-stats-container" data-aos="fade-up">
      <div class="stats-headline">
        <div class="stats-badge">
          <i class="fas fa-chart-line"></i> Trusted by educators worldwide
        </div>
        <h2>Creating impact at <span>scale</span></h2>
      </div>

      <div class="stats-grid">
        <!-- STAT 1: Students -->
        <div class="stat-card" data-target="students">
          <div class="stat-icon">
            <i class="fas fa-user-graduate"></i>
          </div>
          <div class="stat-number">
            <span class="count-up" id="studentsCount">0</span><span>+</span>
          </div>
          <div class="stat-label">Active Students</div>
          <div class="stat-sub">engaged learners worldwide</div>
        </div>

        <!-- optional subtle divider (only on desktop) -->
        <div class="stats-divider"></div>

        <!-- STAT 2: Teachers / Instructors -->
        <div class="stat-card" data-target="teachers">
          <div class="stat-icon">
            <i class="fas fa-chalkboard-user"></i>
          </div>
          <div class="stat-number">
            <span class="count-up" id="teachersCount">0</span><span>+</span>
          </div>
          <div class="stat-label">Expert Teachers</div>
          <div class="stat-sub">certified instructors</div>
        </div>

        <div class="stats-divider"></div>

        <!-- STAT 3: Courses -->
        <div class="stat-card" data-target="courses">
          <div class="stat-icon">
            <i class="fas fa-book-open"></i>
          </div>
          <div class="stat-number">
            <span class="count-up" id="coursesCount">0</span><span>+</span>
          </div>
          <div class="stat-label">Live Courses</div>
          <div class="stat-sub">diverse subjects & pathways</div>
        </div>

        <div class="stats-divider"></div>

        <!-- STAT 4: Certifications / Completion rate (extra credibility) -->
        <div class="stat-card" data-target="certificates">
          <div class="stat-icon">
            <i class="fas fa-certificate"></i>
          </div>
          <div class="stat-number">
            <span class="count-up" id="certificatesCount">0</span><span>k</span>
          </div>
          <div class="stat-label">Certificates Issued</div>
          <div class="stat-sub">career-boosting credentials</div>
        </div>
      </div>

      <div class="trust-footer">
        <i class="fas fa-star-of-life"></i> 98% learner satisfaction •
        <i class="fas fa-globe"></i> 30+ countries •
        <i class="fas fa-clock"></i> 24/7 support
      </div>
    </div>
  </div>

  {{-- ==================== 4. COURSES SECTION (Using your card design) ==================== --}}
  <div class="container my-3 py-5" id="courses">
    <div class="section-header" data-aos="fade-up">
      <span class="badge"><i class="fas fa-graduation-cap me-1"></i> Featured Programs</span>
      <h2>Explore Our Top Courses</h2>
      <p>Handpicked by experts to accelerate your learning journey</p>
    </div>

    <div class="row g-4">


      @forelse($courses as $course)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
          <div class="card course-card h-100">
            <div class="position-relative">
              <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top" alt="{{ $course->title }}">
              <div class="card-img-overlay d-flex align-items-start justify-content-end">
                <form action="{{ route('wishlist.add', $course->id) }}" method="POST">
                  @csrf
                  <button class="btn wishlist-btn btn-sm rounded-circle" type="submit">
                    <i class="{{ in_array($course->id, $wishlistIds) ? 'fas' : 'far' }} fa-heart"></i>
                  </button>
                </form>
              </div>
            </div>
            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-light text-dark">{{ $course->category->name ?? 'General' }} >
                  {{ $course->subCategory->name ?? 'Misc' }}</span>
                <div class="text-warning small">
                  <i class="fas fa-star"></i> {{ $course->reviews_avg_rating ?? 0 }}
                </div>
              </div>
              <h5 class="card-title">{{ Str::limit($course->title, 55) }}</h5>
              <p class="card-text">{!! Str::limit(strip_tags($course->description), 90) !!}</p>
              <div class="course-meta">
                <span><i class="fas fa-user-graduate"></i> {{ $course->enrollments_count ?? 0 }} students</span>
                <span><i class="fas fa-clock"></i> {{ $course->duration ?? 'N/A' }}h</span>
                <span><i class="fas fa-eye"></i> {{ $course->views ?? 0 }}</span>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-auto">
                <div>
                  @if (!auth()->check() || !auth()->user()->canAccessCourse($course->id))
                    @if ($course->pricing && $course->pricing->price > 0)
                      <div class="course-price">
                        {{ $course->pricing->currency_symbol ?? '$' }}{{ $course->pricing->price }}</div>
                    @else
                      <div class="course-price text-success">FREE</div>
                    @endif
                  @endif
                </div>
                <a href="{{ route('courses.course_show', $course->slug) }}" class="btn btn-primary btn-sm">
                  {{ auth()->check() && $course->is_enrolled ? 'Go to course' : 'View Course' }}
                </a>
                <div class="cart-hover-btn">
                  <form action="{{ route('cart.add', $course->id) }}" method="POST">
                    @csrf
                    @if (in_array($course->id, $cartIds))
                      <button class="btn btn-success btn-sm" disabled><i class="fas fa-check me-1"></i> Added</button>
                    @else
                      <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-shopping-cart me-1"></i>
                        Add to Cart</button>
                    @endif
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 py-5 text-center">
          <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
          <h4>No courses available yet</h4>
          <p>Check back soon for exciting new content.</p>
        </div>
      @endforelse
    </div>

    <div class="mt-5 text-center">
      <a href="{{ route('courses.course_index') }}" class="btn btn-primary btn-lg px-5">Browse All Courses <i
          class="fas fa-arrow-right ms-2"></i></a>
    </div>
  </div>


  {{-- 5. LIVE PREVIEW / DEMO SECTION  --}}
  <div class="demo-section-wrapper">
    <div class="live-demo-section" data-aos="fade-up">
      <div class="demo-grid">
        <!-- LEFT SIDE: Small Video (embedded interactive) -->
        <div class="demo-media">
          <div class="video-container">
            <!-- SMALL VIDEO: lorem ipsum demo / example of lms walkthrough (short loop)
                                                                                 Using a high-quality sample from pexels (creative commons) showing learning/dashboard style.
                                                                                 This video represents your LMS platform preview -->
            <video class="demo-video" poster="https://cdn.pixabay.com/video/2023/06/20/169206-835382488_large.jpg"
              controls preload="metadata" loop muted>
              <source src="{{ asset('videos/What is LMS [Learning Management System] - iSpring (720p, h264).mp4') }}"
                type="video/mp4">
              Your browser does not support the video tag. Preview not available.
            </video>
          </div>
        </div>

        <!-- RIGHT SIDE: Content + CTA [ View Demo ] -->
        <div class="demo-content">
          <div class="demo-badge">
            <i class="fas fa-play-circle"></i>
            <span>Live preview</span>
          </div>
          <h3>Experience the<br>LMS in action</h3>
          <p class="demo-description">
            See how intuitive dashboards, smart assignments, and real-time collaboration work. Watch a quick tour of the
            learner & instructor experience.
          </p>
          <ul class="demo-feature-list">
            <li><i class="fas fa-check-circle"></i> Interactive course player</li>
            <li><i class="fas fa-chart-simple"></i> Progress tracking & gamification</li>
            <li><i class="fas fa-comments"></i> Live discussion & messaging</li>
          </ul>

          {{-- <div class="demo-note">
            <i class="fas fa-clock"></i> 2-min interactive overview — no signup required
          </div> --}}
        </div>
      </div>
    </div>
  </div>


  <!-- ========== 6. TESTIMONIALS SECTION ========== -->
  <div class="testimonials-wrapper">
    <div class="testimonials-header">
      <div class="testimonials-badge">
        <i class="fas fa-comment-dots"></i> Social proof
      </div>
      <h2>Loved by <span>learners & educators</span></h2>
      <div class="testimonials-sub">Join thousands who transformed their learning experience</div>
    </div>

    <div class="testimonials-grid">
      <!-- Testimonial 1: Student perspective -->
      <div class="testimonial-card">
        <div class="quote-icon">
          <i class="fas fa-quote-left"></i>
        </div>
        <div class="testimonial-text">
          “This LMS completely changed how I learn. The interactive dashboards and real-time feedback kept me motivated
          throughout the entire course. I finished 3 certifications in just 4 months!”
        </div>
        <div class="rating">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
            class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <div class="author">
          <div class="avatar">
            <i class="fas fa-user-graduate"></i>
          </div>
          <div class="author-info">
            <h4>Emily Rodriguez</h4>
            <p>Marketing Professional · Certified Learner</p>
          </div>
        </div>
      </div>

      <!-- Testimonial 2: Teacher / Instructor perspective -->
      <div class="testimonial-card">
        <div class="quote-icon">
          <i class="fas fa-quote-left"></i>
        </div>
        <div class="testimonial-text">
          “As an educator, the analytics and course builder are a dream. I can track student progress easily and create
          engaging content in minutes. My students' completion rates increased by 40%.”
        </div>
        <div class="rating">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
            class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <div class="author">
          <div class="avatar">
            <i class="fas fa-chalkboard-user"></i>
          </div>
          <div class="author-info">
            <h4>Dr. James Carter</h4>
            <p>Senior Instructor · Math & STEM</p>
          </div>
        </div>
      </div>

      <!-- Testimonial 3: University admin / Institution leader -->
      <div class="testimonial-card">
        <div class="quote-icon">
          <i class="fas fa-quote-left"></i>
        </div>
        <div class="testimonial-text">
          “We migrated our entire university to this platform and never looked back. Seamless integration, outstanding
          support, and the collaboration tools are unmatched. Highly recommended.”
        </div>
        <div class="rating">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
            class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <div class="author">
          <div class="avatar">
            <i class="fas fa-building"></i>
          </div>
          <div class="author-info">
            <h4>Prof. Linda Okonkwo</h4>
            <p>Dean of eLearning · Global University</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional trust badge / verified reviews (extra credibility) -->
    <div class="trust-badge">
      <span><i class="fas fa-check-circle"></i> 500+ verified reviews</span>
      <span><i class="fas fa-star"></i> 4.9/5 average rating</span>
      <span><i class="fas fa-shield-alt"></i> Trusted by 50+ institutions</span>
    </div>
  </div>


  {{-- ==================== 7. CONTACT SECTION (Your design) ==================== --}}
  <div class="container mb-5 py-4">
    <div class="contact-section" data-aos="fade-up">
      <div class="row g-4 align-items-stretch">
        <!-- Left Info -->
        <div class="col-lg-5">
          <div class="card-contact h-100">
            <div class="card-body p-lg-5 p-4">
              <div class="mb-4 text-center">
                <div class="contact-icon mx-auto"><i class="fas fa-headset"></i></div>
                <h3 class="fw-bold" style="color: var(--primary-dark);">Let's Talk</h3>
                <p class="text-muted">We're here to answer your questions and help you choose the right course.</p>
              </div>
              <div class="info-item">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="info-content">
                  <h6>Visit Us</h6>
                  <p>{{ $setting->site_address ?? '123 Learning Ave, Digital City' }}</p>
                </div>
              </div>
              <div class="info-item">
                <div class="info-icon"><i class="fas fa-envelope"></i></div>
                <div class="info-content">
                  <h6>Email Support</h6>
                  <p>{{ $setting->site_email ?? 'hello@coursedly.com' }}</p>
                </div>
              </div>
              <div class="info-item">
                <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="info-content">
                  <h6>Call Us</h6>
                  <p>{{ $setting->site_phone ?? '+1 (800) 234-5678' }}<br><small>Mon-Fri 9am-6pm</small></p>
                </div>
              </div>
              <hr>
              <h5 class="fw-semibold">Connect With Us</h5>
              <div class="social-links">
                @php
                  $socials =
                      isset($socialLinks) && $socialLinks->count()
                          ? $socialLinks
                          : collect([
                              (object) ['icon_class' => 'fab fa-facebook-f', 'url' => '#'],
                              (object) ['icon_class' => 'fab fa-twitter', 'url' => '#'],
                              (object) ['icon_class' => 'fab fa-linkedin-in', 'url' => '#'],
                              (object) ['icon_class' => 'fab fa-instagram', 'url' => '#'],
                          ]);
                @endphp
                @foreach ($socials as $social)
                  <a href="{{ $social->url ?? '#' }}" class="social-icon"><i
                      class="{{ $social->icon_class }}"></i></a>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <!-- Right Form -->
        <div class="col-lg-7">
          <div class="card-contact h-100">
            <div class="card-body p-lg-5 p-4">
              <h3 class="fw-bold">Send a Message</h3>
              <p class="text-muted mb-4">Fill the form and our team will get back to you within 24h.</p>
              <form id="contactForm" method="POST" action="{{ route('contact.send') }}">
                @csrf
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="floating-label">
                      <input type="text" id="name" name="name" placeholder=" " required>
                      <label for="name">Full name *</label>
                      <div class="invalid-feedback">Please enter your name.</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="floating-label">
                      <input type="email" id="email" name="email" placeholder=" " required>
                      <label for="email">Email address *</label>
                      <div class="invalid-feedback">Valid email required.</div>
                    </div>
                  </div>
                </div>
                <div class="floating-label">
                  <input type="text" id="subject" name="subject" placeholder=" " required>
                  <label for="subject">Subject *</label>
                  <div class="invalid-feedback">Subject is required.</div>
                </div>
                <div class="floating-label">
                  <textarea id="message" name="message" rows="4" placeholder=" " required></textarea>
                  <label for="message">Message *</label>
                  <div class="invalid-feedback">Please enter your message.</div>
                </div>
                <div class="d-grid mt-3">
                  <button type="submit" class="btn btn-primary-custom submit-btn" id="submitBtn">
                    <span id="btnText">Send Message <i class="fas fa-paper-plane ms-2"></i></span>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                      style="display:none;"></span>
                  </button>
                </div>
                <p class="text-muted small mt-3 text-center">We respect your privacy. No spam, ever.</p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Swiper Slider
    const swiper = new Swiper('.hero-swiper', {
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 5500,
        disableOnInteraction: false
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true
      },
      grabCursor: true,
    });

    // AOS Animations
    AOS.init({
      duration: 800,
      once: true,
      offset: 80
    });


    // VALUE SECTION
    AOS.init({
      duration: 800, // values from 600 to 1000
      once: true, // animation happens only once while scrolling down (clean)
      offset: 80, // offset (in px) from the original trigger point
      easing: 'ease-out-quad',
      disable: false, // accepts responsive condition
    });

    // Optional: add a small scroll effect for the page, to ensure any anchor links work smoothly
    document.querySelectorAll('.cta-link').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        if (this.getAttribute('href') === '#') {
          e.preventDefault();
          // just a demo - smooth scroll to value section (but already visible)
          document.getElementById('valueSection').scrollIntoView({
            behavior: 'smooth'
          });
        }
      });
    });

    // TRUST SECTION
    (function() {
      // final target values (you can easily customize these numbers)
      const statsData = {
        students: {
          elementId: 'studentsCount',
          targetValue: 1250,
          suffix: '',
          isK: false
        }, // 1250+ students
        teachers: {
          elementId: 'teachersCount',
          targetValue: 84,
          suffix: '',
          isK: false
        }, // 84+ teachers
        courses: {
          elementId: 'coursesCount',
          targetValue: 210,
          suffix: '',
          isK: false
        }, // 210+ courses
        certificates: {
          elementId: 'certificatesCount',
          targetValue: 15,
          suffix: '',
          isK: true
        } // 15k certificates -> 15 + 'k'
      };

      // adjust for certificate display: 15k
      // we treat certificate specially: targetValue = 15, and we add "k" after number.
      let animated = false;
      let observer = null;

      // get the stats container element
      const statsContainer = document.querySelector('.trust-stats-container');
      if (!statsContainer) return;

      // function to animate counting
      function animateNumber(element, start, end, duration = 1500, isK = false) {
        if (!element) return;
        let startTimestamp = null;
        const step = (timestamp) => {
          if (!startTimestamp) startTimestamp = timestamp;
          const progress = Math.min((timestamp - startTimestamp) / duration, 1);
          const current = Math.floor(progress * (end - start) + start);
          if (isK) {
            element.innerText = current + 'k';
          } else {
            element.innerText = current;
          }
          if (progress < 1) {
            window.requestAnimationFrame(step);
          } else {
            // final set to exact target
            if (isK) {
              element.innerText = end + 'k';
            } else {
              element.innerText = end;
            }
          }
        };
        window.requestAnimationFrame(step);
      }

      // start all counters when section becomes visible (🔥)
      function startCounters() {
        if (animated) return;
        animated = true;

        // get each element and start counting
        const studentsEl = document.getElementById('studentsCount');
        const teachersEl = document.getElementById('teachersCount');
        const coursesEl = document.getElementById('coursesCount');
        const certEl = document.getElementById('certificatesCount');

        if (studentsEl) {
          animateNumber(studentsEl, 0, statsData.students.targetValue, 1400, false);
        }
        if (teachersEl) {
          animateNumber(teachersEl, 0, statsData.teachers.targetValue, 1200, false);
        }
        if (coursesEl) {
          animateNumber(coursesEl, 0, statsData.courses.targetValue, 1300, false);
        }
        if (certEl) {
          // certificate shows 15k => targetValue = 15, and we append 'k'
          animateNumber(certEl, 0, statsData.certificates.targetValue, 1350, true);
        }
      }

      // Intersection Observer to trigger counters when section appears on viewport
      if ('IntersectionObserver' in window) {
        observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting && !animated) {
              startCounters();
              // unobserve after triggering to avoid extra calls
              if (observer && statsContainer) observer.unobserve(statsContainer);
            }
          });
        }, {
          threshold: 0.25
        }); // trigger when 25% visible

        observer.observe(statsContainer);
      } else {
        // fallback for older browsers: start counters immediately
        startCounters();
      }

      // Also ensure if user navigates quickly with anchor, we trigger again but only once
      window.addEventListener('load', function() {
        // if container is already visible before observer kicks (edge)
        if (!animated && statsContainer && statsContainer.getBoundingClientRect().top < window.innerHeight - 100) {
          startCounters();
          if (observer && statsContainer) observer.unobserve(statsContainer);
        }
      });
    })();


    // Contact form validation + loading state
    const form = document.getElementById('contactForm');
    if (form) {
      form.addEventListener('submit', function(e) {
        let isValid = true;
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const subject = document.getElementById('subject');
        const message = document.getElementById('message');

        document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');
        [name, email, subject, message].forEach(f => f.classList.remove('is-invalid'));

        if (!name.value.trim()) {
          showError(name, 'Please enter your name.');
          isValid = false;
        }
        const emailPattern = /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/;
        if (!email.value.trim() || !emailPattern.test(email.value)) {
          showError(email, 'Valid email address is required.');
          isValid = false;
        }
        if (!subject.value.trim()) {
          showError(subject, 'Please enter a subject.');
          isValid = false;
        }
        if (!message.value.trim()) {
          showError(message, 'Message cannot be empty.');
          isValid = false;
        }

        if (!isValid) {
          e.preventDefault();
          return;
        }

        // Show loading
        const btn = document.getElementById('submitBtn');
        const spinner = btn.querySelector('.spinner-border');
        const btnText = document.getElementById('btnText');
        btn.disabled = true;
        spinner.style.display = 'inline-block';
        btnText.innerHTML = 'Sending...';
      });
    }

    function showError(field, msg) {
      field.classList.add('is-invalid');
      const feedback = field.parentElement.querySelector('.invalid-feedback');
      if (feedback) {
        feedback.innerText = msg;
        feedback.style.display = 'block';
      }
    }
  </script>
@endpush
