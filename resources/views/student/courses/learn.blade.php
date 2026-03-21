<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Continue Learning - {{ $course->title }} | Udemy</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <style>
    :root {
      --udemy-purple: #5624d0;
      --udemy-dark: #1c1d1f;
      --udemy-gray: #6a6f73;
      --udemy-light-gray: #d1d7dc;
      --udemy-light-bg: #f7f9fa;
      --udemy-yellow: #f3ca8c;
      --udemy-orange: #b4690e;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--udemy-dark);
      background-color: #fff;
      line-height: 1.4;
    }

    .star-rating {
      font-size: 2rem;
      cursor: pointer;
      color: #ddd;
    }

    .star-rating span {
      margin: 0 3px;
      transition: 0.2s;
    }

    .star-rating span.active,
    .star-rating span.hover {
      color: #f4c150;
      /* Udemy yellow */
    }

    .udemy-navbar {
      background-color: #fff;
      border-bottom: 1px solid var(--udemy-light-gray);
      padding: 0.5rem 0;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .udemy-logo {
      font-weight: bold;
      color: var(--udemy-purple);
      font-size: 1.5rem;
      text-decoration: none;
    }

    .udemy-search {
      background-color: var(--udemy-light-bg);
      border: 1px solid var(--udemy-light-gray);
      border-radius: 9999px;
      padding: 0.5rem 1rem;
      width: 100%;
      max-width: 500px;
    }

    .udemy-btn {
      border-radius: 0;
      padding: 0.5rem 1rem;
      font-weight: 600;
    }

    .udemy-btn-primary {
      background-color: #0B8E96;
      border-color: #0B8E96;
      color: white;
    }

    .udemy-btn-primary:hover {
      background-color: #0B8E96;
      border-color: #0B8E96;
    }

    .udemy-btn-outline {
      border: 1px solid var(--udemy-dark);
      color: var(--udemy-dark);
      background-color: transparent;
    }

    .udemy-btn-outline:hover {
      background-color: rgba(0, 0, 0, 0.04);
    }

    .progress-container {
      background-color: var(--udemy-light-bg);
      padding: 1.5rem;
      border-radius: 4px;
      margin-bottom: 2rem;
    }

    .progress-bar-udemy {
      background-color: var(--udemy-purple);
      border-radius: 9999px;
    }

    .course-title {
      color: var(--udemy-dark);
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .instructor-name {
      color: var(--udemy-gray);
      font-size: 0.9rem;
    }

    .section-card {
      border: 1px solid var(--udemy-light-gray);
      border-radius: 4px;
      margin-bottom: 0.5rem;
      overflow: hidden;
    }

    .section-header {
      background-color: var(--udemy-light-bg);
      padding: 1rem;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .section-header:hover {
      background-color: rgba(0, 0, 0, 0.02);
    }

    .section-content {
      padding: 0;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }

    .section-content.expanded {
      max-height: 1000px;
    }

    .lecture-item {
      padding: 0.75rem 1rem;
      border-bottom: 1px solid var(--udemy-light-gray);
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .lecture-item:last-child {
      border-bottom: none;
    }

    .lecture-item:hover {
      background-color: rgba(0, 0, 0, 0.02);
    }

    .lecture-item.completed .lecture-title {
      color: var(--udemy-gray);
    }

    .lecture-item.current {
      background-color: rgba(86, 36, 208, 0.05);
      border-left: 3px solid var(--udemy-purple);
    }

    .lecture-icon {
      color: var(--udemy-gray);
      margin-right: 1rem;
      width: 24px;
      text-align: center;
    }

    .lecture-item.completed .lecture-icon {
      color: var(--udemy-purple);
    }

    .lecture-duration {
      color: var(--udemy-gray);
      font-size: 0.8rem;
      margin-left: auto;
    }

    .sidebar-card {
      border: 1px solid var(--udemy-light-gray);
      border-radius: 4px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .video-player {
      background-color: #000;
      border-radius: 4px;
      height: 400px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      margin-bottom: 1.5rem;
      position: relative;
    }

    .video-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .play-button {
      background-color: var(--udemy-purple);
      border: none;
      border-radius: 50%;
      width: 70px;
      height: 70px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 1rem;
      cursor: pointer;
    }

    .play-button i {
      font-size: 1.5rem;
      color: white;
      margin-left: 5px;
    }

    .continue-btn {
      width: 100%;
      padding: 0.75rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .resources-list {
      list-style-type: none;
      padding-left: 0;
    }

    .resources-list li {
      padding: 0.5rem 0;
      border-bottom: 1px solid var(--udemy-light-gray);
    }

    .resources-list li:last-child {
      border-bottom: none;
    }

    .resources-list a {
      color: var(--udemy-purple);
      text-decoration: none;
    }

    .resources-list a:hover {
      text-decoration: underline;
    }

    .footer {
      background-color: var(--udemy-dark);
      color: white;
      padding: 3rem 0 2rem;
      margin-top: 3rem;
    }

    .footer-links {
      list-style-type: none;
      padding-left: 0;
    }

    .footer-links li {
      margin-bottom: 0.5rem;
    }

    .footer-links a {
      color: white;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .footer-links a:hover {
      text-decoration: underline;
    }

    .copyright {
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      padding-top: 1.5rem;
      margin-top: 2rem;
      font-size: 0.8rem;
      color: rgba(255, 255, 255, 0.7);
    }

    .badge {
      background-color: var(--udemy-yellow);
      color: var(--udemy-orange);
      font-weight: 600;
      padding: 0.25rem 0.5rem;
      border-radius: 4px;
      font-size: 0.8rem;
    }

    .quiz-item {
      background-color: rgba(243, 202, 140, 0.1);
      border-left: 3px solid var(--udemy-yellow);
    }

    /* Video player specific styles */
    #videoPlayer video {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    @media (max-width: 992px) {
      .sidebar-card {
        margin-top: 2rem;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 shadow-sm">
    <div class="container-fluid">

      <!-- Left: Brand / Logo -->
      <a class="navbar-brand fw-bold" href="{{ route('home.index') }}">

        <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->site_name }}" width="100px">
      </a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#courseNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Content -->
      <div class="navbar-collapse collapse" id="courseNavbar">

        <!-- Center: Course Title -->
        <ul class="navbar-nav mb-lg-0 mb-2 me-auto">
          <li class="nav-item">
            <span class="nav-link active fw-semibold">
              {{ $course->title }}
            </span>
          </li>
        </ul>

        <!-- Right Side Actions -->
        <div class="d-flex align-items-center gap-2">

          @if (!$course->hasReview($course->id))
            <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal">
              ⭐ Write Review
            </button>
          @endif

          <!-- User Dropdown (Optional) -->
          @auth
            <div class="dropdown">
              <button class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
              </button>

              <ul class="dropdown-menu dropdown-menu-end">

                <li>
                  <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                    Logout
                  </a>
                </li>
              </ul>
            </div>
          @endauth

        </div>

      </div>
    </div>
  </nav>


  <div class="container mt-4">
    <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8">
        <!-- Progress Header -->
        <div class="progress-container">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h2 class="course-title mb-1">{{ $course->title }}</h2>
              <p class="instructor-name mb-0">Course Progress</p>
            </div>
            <div class="text-end">
              <div class="badge mb-2" id="progressPercent">0% COMPLETE</div>
              <p class="small text-muted mb-0" id="lectureCount">0 of {{ $totalLectures }} items completed</p>
            </div>
          </div>

          <div class="progress mb-2" style="height: 8px;">
            <div class="progress-bar progress-bar-udemy" id="progressBar" role="progressbar" style="width: 0%;"
              aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>

          <div class="d-flex justify-content-between small text-muted">
            <span id="completedCount">0 completed</span>
            <span id="remainingCount">{{ $totalLectures }} remaining</span>
          </div>
        </div>

        <!-- Video Player -->
        <div class="video-player">
          @if ($currentLecture && $currentLecture->video_file)
            <video id="courseVideo" controls class="w-100 h-100">
              <source src="{{ asset('storage/' . $currentLecture->video_file) }}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
            <div class="video-overlay" id="videoOverlay">
              <div class="play-button" id="playButton">
                <i class="fas fa-play"></i>
              </div>
              <h4 id="videoTitle">{{ $currentLecture->title }}</h4>
              <p class="mb-0">Click to play the video</p>
            </div>
          @else
            <div class="video-overlay">
              <div class="play-button" style="opacity: 0.5; cursor: not-allowed;">
                <i class="fas fa-video-slash"></i>
              </div>
              <h4 id="videoTitle">
                {{ $currentLecture ? $currentLecture->title : 'Select a lecture to begin' }}
              </h4>
              <p class="mb-0">
                {{ $currentLecture && !$currentLecture->video_file ? 'No video available for this lecture' : 'Select a lecture to begin' }}
              </p>
            </div>
          @endif
        </div>

        <!-- Course Content Sections -->
        <h3 class="mb-3">Course content</h3>

        @foreach ($course->sections as $sectionIndex => $section)
          <div class="section-card">
            <div class="section-header" data-section="{{ $section->id }}">
              <div>
                <h5 class="mb-1">Section {{ $sectionIndex + 1 }}: {{ $section->title }}</h5>
                <p class="small text-muted mb-0">
                  {{ $section->lectures->count() }} lectures •
                  {{ $section->lectures->sum('duration') }}min
                </p>
              </div>
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="section-content" id="section-{{ $section->id }}">
              @foreach ($section->lectures as $lectureIndex => $lecture)
                <div
                  class="lecture-item {{ $currentLecture && $currentLecture->id == $lecture->id ? 'current' : '' }} {{ $lecture->is_completed ? 'completed' : '' }}"
                  data-lecture-id="{{ $lecture->id }}"
                  data-video-url="{{ $lecture->video_file ? asset('storage/' . $lecture->video_file) : '' }}"
                  data-lecture-title="{{ $lecture->title }}">
                  <div class="lecture-icon">
                    @if ($lecture->is_completed)
                      <i class="fas fa-check-circle"></i>
                    @elseif($currentLecture && $currentLecture->id == $lecture->id)
                      <i class="fas fa-play-circle"></i>
                    @else
                      <i class="far fa-circle"></i>
                    @endif
                  </div>
                  <div>
                    <div class="lecture-title">{{ $sectionIndex + 1 }}.{{ $lectureIndex + 1 }} {{ $lecture->title }}
                    </div>
                    @if ($lecture->description)
                      <small class="text-muted">{{ Str::limit($lecture->description, 50) }}</small>
                    @endif
                  </div>
                  <div class="lecture-duration">{{ $lecture->duration }}min</div>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="sidebar-card">
          <h5 class="mb-3">What's next</h5>
          <p class="small">Complete the current lecture to continue to the next item.</p>

          <button class="btn udemy-btn udemy-btn-primary continue-btn" id="markCompleteBtn">
            <i class="fas fa-check-circle me-2"></i> Mark as complete
          </button>

          <button class="btn udemy-btn udemy-btn-outline continue-btn" id="nextLectureBtn">
            <i class="fas fa-forward me-2"></i> Next lecture
          </button>

          @if ($currentLecture)
            <div class="mt-4">
              <h6>Lecture Resources</h6>
              <ul class="resources-list" id="lectureResources">
                @if ($currentLecture->description)
                  <li><i class="fas fa-info-circle me-2"></i> {{ Str::limit($currentLecture->description, 60) }}</li>
                @endif
                @if ($currentLecture->materials && $currentLecture->materials->count() > 0)
                  @foreach ($currentLecture->materials as $material)
                    <li>
                      <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" download>
                        <i class="fas fa-download me-2"></i> {{ $material->name }}
                      </a>
                    </li>
                  @endforeach
                @else
                  <li class="text-muted">No resources available for this lecture</li>
                @endif
              </ul>
            </div>
          @endif
        </div>

        <div class="sidebar-card">
          <h5 class="mb-3">Course details</h5>
          <div class="mb-2">
            <div class="small text-muted">Total Lectures</div>
            <div class="fw-medium">{{ $totalLectures }}</div>
          </div>
          <div class="mb-2">
            <div class="small text-muted">Total Duration</div>
            <div class="fw-medium">
              {{ $course->formattedDuration() }}
            </div>
          </div>
          <div class="mb-2">
            <div class="small text-muted">Sections</div>
            <div class="fw-medium">{{ $course->sections->count() }}</div>
          </div>
          <div class="mb-2">
            <div class="small text-muted">Last Updated</div>
            <div class="fw-medium">{{ $course->updated_at->format('M d, Y') }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- Review Modal --}}
  <div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <form action="{{ route('student.course.review', $course->id) }}" method="POST">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title">Rate This Course</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body text-center">

            {{-- Star Rating --}}
            <div class="star-rating mb-3">

              <span data-value="1">★</span>
              <span data-value="2">★</span>
              <span data-value="3">★</span>
              <span data-value="4">★</span>
              <span data-value="5">★</span>

            </div>

            <input type="hidden" name="rating" id="ratingValue" required>

            {{-- Review Text --}}
            <textarea name="review" class="form-control" placeholder="Share your experience..." rows="4"></textarea>

          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
              Submit Review
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Elements
      const videoPlayer = document.getElementById('courseVideo');
      const videoOverlay = document.getElementById('videoOverlay');
      const playButton = document.getElementById('playButton');
      const videoTitle = document.getElementById('videoTitle');
      const markCompleteBtn = document.getElementById('markCompleteBtn');
      const nextLectureBtn = document.getElementById('nextLectureBtn');
      const lectureResources = document.getElementById('lectureResources');

      // Progress elements
      const progressBar = document.getElementById('progressBar');
      const progressPercent = document.getElementById('progressPercent');
      const lectureCount = document.getElementById('lectureCount');
      const completedCount = document.getElementById('completedCount');
      const remainingCount = document.getElementById('remainingCount');

      // Get total lectures count from PHP
      const totalLectures = {{ $totalLectures }};
      let completedLectures = getCompletedLectures();
      let currentLectureId = {{ $currentLecture ? $currentLecture->id : 'null' }};

      // Initialize progress
      updateProgress();

      // Toggle section expansion
      const sectionHeaders = document.querySelectorAll('.section-header');
      sectionHeaders.forEach(header => {
        header.addEventListener('click', function() {
          const sectionId = this.getAttribute('data-section');
          const sectionContent = document.getElementById(`section-${sectionId}`);
          const icon = this.querySelector('i');

          sectionContent.classList.toggle('expanded');

          if (sectionContent.classList.contains('expanded')) {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
          } else {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
          }
        });
      });

      // Expand sections containing current lecture
      if (currentLectureId) {
        const currentLectureItem = document.querySelector(`[data-lecture-id="${currentLectureId}"]`);
        if (currentLectureItem) {
          const sectionContent = currentLectureItem.closest('.section-content');
          if (sectionContent) {
            sectionContent.classList.add('expanded');
            const sectionHeader = sectionContent.previousElementSibling;
            if (sectionHeader) {
              const icon = sectionHeader.querySelector('i');
              icon.classList.remove('fa-chevron-down');
              icon.classList.add('fa-chevron-up');
            }
          }
        }
      }

      // Video play button functionality
      if (playButton && videoPlayer) {
        // Auto-complete when video ends
        videoPlayer.addEventListener('ended', function() {

          if (!currentLectureId) return;

          markLectureAsComplete(currentLectureId).then(success => {

            if (success) {

              const currentItem = document.querySelector(
                `[data-lecture-id="${currentLectureId}"]`
              );

              if (currentItem && !currentItem.classList.contains('completed')) {

                // Mark UI completed
                currentItem.classList.add('completed');

                const icon = currentItem.querySelector('.lecture-icon i');
                icon.className = 'fas fa-check-circle';

                // Update progress
                completedLectures = getCompletedLectures();
                updateProgress();

                // Update button
                markCompleteBtn.innerHTML =
                  '<i class="fas fa-check me-2"></i> Completed';

                markCompleteBtn.classList.remove('udemy-btn-primary');
                markCompleteBtn.classList.add('btn-success');
                markCompleteBtn.disabled = true;

                showNotification('Lecture completed automatically 🎉');

                // Auto play next lecture (optional)
                setTimeout(() => {
                  const next = getNextLecture(currentLectureId);
                  if (next) {
                    next.click();
                  }
                }, 1500);
              }
            }

          });
        });

        playButton.addEventListener('click', function() {
          videoPlayer.play();
          videoOverlay.style.display = 'none';
        });

        videoPlayer.addEventListener('play', function() {
          videoOverlay.style.display = 'none';
        });

        videoPlayer.addEventListener('pause', function() {
          videoOverlay.style.display = 'flex';
        });
      }

      // Handle lecture clicks
      const lectureItems = document.querySelectorAll('.lecture-item');
      lectureItems.forEach(item => {
        item.addEventListener('click', function() {
          const lectureId = this.getAttribute('data-lecture-id');
          const videoUrl = this.getAttribute('data-video-url');
          const lectureTitle = this.getAttribute('data-lecture-title');

          // Update current lecture indicator
          lectureItems.forEach(lecture => {
            lecture.classList.remove('current');
            const icon = lecture.querySelector('.lecture-icon i');
            if (lecture.classList.contains('completed')) {
              icon.className = 'fas fa-check-circle';
            } else {
              icon.className = 'far fa-circle';
            }
          });

          this.classList.add('current');
          const currentIcon = this.querySelector('.lecture-icon i');
          currentIcon.className = 'fas fa-play-circle';

          // Update video player
          updateVideoPlayer(lectureId, videoUrl, lectureTitle);

          // Update URL without page reload
          updateUrlParameter('lecture', lectureId);

          // Update current lecture ID
          currentLectureId = lectureId;

          // Update resources section
          updateLectureResources(lectureId);

          // Scroll to video player
          document.querySelector('.video-player').scrollIntoView({
            behavior: 'smooth'
          });
        });
      });

      // Mark as complete button
      markCompleteBtn.addEventListener('click', function() {
        if (this.disabled) return;
        if (!currentLectureId) return;

        markLectureAsComplete(currentLectureId).then(success => {
          if (success) {
            // Update UI
            const currentItem = document.querySelector(`[data-lecture-id="${currentLectureId}"]`);
            if (currentItem) {
              currentItem.classList.add('completed');
              const icon = currentItem.querySelector('.lecture-icon i');
              icon.className = 'fas fa-check-circle';

              // Update progress
              completedLectures++;
              updateProgress();

              // Show notification
              showNotification('Lecture marked as complete!');

              // Update button state
              markCompleteBtn.innerHTML = '<i class="fas fa-check me-2"></i> Completed';
              markCompleteBtn.classList.remove('udemy-btn-primary');
              markCompleteBtn.classList.add('btn-success');
              markCompleteBtn.disabled = true;
            }
          }
        });
      });

      // Next lecture button
      nextLectureBtn.addEventListener('click', function() {
        if (!currentLectureId) return;

        const nextLecture = getNextLecture(currentLectureId);
        if (nextLecture) {
          nextLecture.click(); // Simulate click on next lecture
        } else {
          showNotification('You have completed all lectures!', 'info');
        }
      });

      // Functions
      function updateVideoPlayer(lectureId, videoUrl, title) {
        if (!videoUrl) {
          // No video available
          videoTitle.textContent = title;
          if (videoPlayer) {
            videoPlayer.style.display = 'none';
          }
          videoOverlay.innerHTML = `
            <div class="play-button" style="opacity: 0.5; cursor: not-allowed;">
              <i class="fas fa-video-slash"></i>
            </div>
            <h4>${title}</h4>
            <p class="mb-0">No video available for this lecture</p>
          `;
          videoOverlay.style.display = 'flex';
          return;
        }

        // Update video source
        if (videoPlayer) {
          videoPlayer.src = videoUrl;
          videoPlayer.load(); // IMPORTANT

          videoPlayer.style.display = 'block';
          videoOverlay.style.display = 'flex';
          videoTitle.textContent = title;

          // Reset play button
          const playBtn = videoOverlay.querySelector('.play-button');
          if (playBtn) {
            playBtn.innerHTML = '<i class="fas fa-play"></i>';
            playBtn.onclick = function() {
              videoPlayer.play();
              videoOverlay.style.display = 'none';
            };
          }
        }
      }

      function updateUrlParameter(key, value) {
        const url = new URL(window.location);
        url.searchParams.set(key, value);
        window.history.pushState({}, '', url);
      }

      function updateProgress() {
        const percentage = totalLectures > 0 ? Math.round((completedLectures / totalLectures) * 100) : 0;

        if (progressBar) {
          progressBar.style.width = percentage + '%';
          progressBar.setAttribute('aria-valuenow', percentage);
        }

        if (progressPercent) {
          progressPercent.textContent = percentage + '% COMPLETE';
        }

        if (lectureCount) {
          lectureCount.textContent = `${completedLectures} of ${totalLectures} items completed`;
        }

        if (completedCount) {
          completedCount.textContent = `${completedLectures} completed`;
        }

        if (remainingCount) {
          remainingCount.textContent = `${totalLectures - completedLectures} remaining`;
        }
      }

      function getCompletedLectures() {
        // Count completed lectures from DOM
        const completedItems = document.querySelectorAll('.lecture-item.completed');
        return completedItems.length;
      }

      function getNextLecture(currentId) {
        const allLectures = Array.from(document.querySelectorAll('.lecture-item'));
        const currentIndex = allLectures.findIndex(item =>
          item.getAttribute('data-lecture-id') == currentId
        );

        if (currentIndex < allLectures.length - 1) {
          return allLectures[currentIndex + 1];
        }
        return null;
      }

      async function markLectureAsComplete(lectureId) {
        try {
          const response = await fetch(`/lectures/${lectureId}/complete`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          });

          return response.ok;
        } catch (error) {
          console.error('Error marking lecture as complete:', error);
          return false;
        }
      }

      async function updateLectureResources(lectureId) {
        try {
          const response = await fetch(`/lectures/${lectureId}/resources`);
          if (response.ok) {
            const data = await response.json();
            if (lectureResources) {
              lectureResources.innerHTML = data.resources;
            }
          }
        } catch (error) {
          console.error('Error fetching resources:', error);
        }
      }

      function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `position-fixed bottom-0 end-0 m-3 p-3 
          ${type === 'success' ? 'bg-success' : 'bg-info'} 
          text-white rounded shadow`;
        notification.style.zIndex = '1050';
        notification.innerHTML = `
          <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            <div>${message}</div>
          </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
          notification.remove();
        }, 3000);
      }

      // Initialize mark complete button state
      if (currentLectureId) {
        const currentItem = document.querySelector(`[data-lecture-id="${currentLectureId}"]`);
        if (currentItem && currentItem.classList.contains('completed')) {
          markCompleteBtn.innerHTML = '<i class="fas fa-check me-2"></i> Completed';
          markCompleteBtn.classList.remove('udemy-btn-primary');
          markCompleteBtn.classList.add('btn-success');
          markCompleteBtn.disabled = true;
        }
      }
    });

    document.addEventListener('DOMContentLoaded', function() {

      const stars = document.querySelectorAll('.star-rating span');
      const ratingInput = document.getElementById('ratingValue');

      stars.forEach((star, index) => {

        // Hover
        star.addEventListener('mouseover', function() {

          resetStars();

          for (let i = 0; i <= index; i++) {
            stars[i].classList.add('hover');
          }

        });

        // Click
        star.addEventListener('click', function() {

          ratingInput.value = index + 1;

          resetStars();

          for (let i = 0; i <= index; i++) {
            stars[i].classList.add('active');
          }

        });

        // Remove hover
        star.addEventListener('mouseout', function() {

          resetStars();

          let current = ratingInput.value;

          for (let i = 0; i < current; i++) {
            stars[i].classList.add('active');
          }

        });

      });

      function resetStars() {
        stars.forEach(star => {
          star.classList.remove('hover', 'active');
        });
      }

    });
  </script>
</body>

</html>
