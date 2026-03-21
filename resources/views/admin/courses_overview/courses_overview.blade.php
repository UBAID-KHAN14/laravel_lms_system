@extends('adminlte::page')

@push('css')
  <style>
    :root {
      --primary-color: #3490dc;
      --success-color: #38c172;
      --warning-color: #f6993f;
      --danger-color: #e3342f;
      --gray-light: #f8f9fa;
    }

    .course-preview-container {
      background-color: #f5f7fa;
      min-height: 100vh;
    }

    .header-card {
      background: linear-gradient(135deg, #343a40 0%, #1f2d3d 100%);
      color: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }

    .header-card .card-body {
      padding: 2.5rem;
    }

    .status-badge {
      font-size: 0.9rem;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      letter-spacing: 0.5px;
      background: #6c757d;
      color: white;
    }

    .status-badge.published {
      background: var(--success-color);
    }

    .status-badge.pending {
      background: var(--warning-color);
    }

    .status-badge.rejected {
      background: var(--danger-color);
    }

    .status-badge.draft {
      background: #6c757d;
    }

    .content-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
      margin-bottom: 1.5rem;
      border: none;
    }

    .content-card .card-header {
      background: white;
      border-bottom: 2px solid var(--gray-light);
      padding: 1.5rem;
      font-weight: 600;
      font-size: 1.2rem;
      color: #2d3748;
      border-radius: 12px 12px 0 0;
    }

    .content-card .card-body {
      padding: 1.5rem;
    }

    .preview-thumbnail {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .preview-thumbnail:hover {
      transform: scale(1.02);
    }

    .lecture-item {
      border-left: 3px solid transparent;
      transition: all 0.3s ease;
      padding: 1rem 1.25rem;
      border-bottom: 1px solid #f1f1f1;
    }

    .lecture-item:hover {
      border-left-color: var(--primary-color);
      background-color: rgba(52, 144, 220, 0.05);
      transform: translateX(5px);
    }

    .material-badge {
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .material-badge:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .video-preview-btn {
      position: relative;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      background: var(--primary-color);
      border: none;
      color: white;
      transition: all 0.3s ease;
    }

    .video-preview-btn:hover {
      background: #2779bd;
      transform: scale(1.1);
    }

    .rejection-box {
      background: linear-gradient(135deg, #fdf2f2 0%, #fff5f5 100%);
      border-left: 4px solid var(--danger-color);
    }

    .requirement-item {
      display: flex;
      align-items: center;
      padding: 0.75rem;
      border-radius: 8px;
      margin-bottom: 0.5rem;
      background: var(--gray-light);
    }

    .requirement-item.valid {
      background: #f0fff4;
      border-left: 3px solid var(--success-color);
    }

    .requirement-item.invalid {
      background: #fff5f5;
      border-left: 3px solid var(--danger-color);
    }

    .stat-card {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--primary-color);
      line-height: 1;
    }

    .action-btn {
      width: 100%;
      padding: 1rem;
      text-align: left;
      border: none;
      background: white;
      border-radius: 8px;
      margin-bottom: 0.75rem;
      transition: all 0.3s ease;
      border: 2px solid transparent;
      display: block;
      text-decoration: none;
      color: inherit;
    }

    .action-btn:hover {
      border-color: var(--primary-color);
      transform: translateY(-2px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
      text-decoration: none;
      color: inherit;
    }

    .section-header {
      background: linear-gradient(135deg, #343a40 0%, #1f2d3d 100%);
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      margin-bottom: 1rem;
    }

    .video-player-wrapper {
      position: relative;
      width: 100%;
      padding-bottom: 56.25%;
      /* 16:9 Aspect Ratio */
      height: 0;
      overflow: hidden;
      background: #000;
      border-radius: 8px 8px 0 0;
    }

    .video-player-wrapper iframe,
    .video-player-wrapper video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: none;
    }

    .material-list {
      max-height: 300px;
      overflow-y: auto;
    }

    .admin-notes {
      min-height: 200px;
      border: 1px solid #e9ecef;
      border-radius: 5px;
      padding: 10px;
      background-color: #f8f9fa;
    }

    .cursor-pointer {
      cursor: pointer;
    }

    .video-url-display {
      background: #f8f9fa;
      border-radius: 4px;
      padding: 8px 12px;
      margin-top: 10px;
      font-family: monospace;
      font-size: 12px;
      word-break: break-all;
      border: 1px solid #dee2e6;
    }

    .all-videos-item {
      transition: all 0.2s;
      border-left: 3px solid transparent;
    }

    .all-videos-item:hover {
      border-left-color: var(--primary-color);
      background-color: rgba(52, 144, 220, 0.05);
    }

    .video-source-badge {
      font-size: 0.7rem;
      padding: 0.2rem 0.5rem;
      border-radius: 3px;
      margin-left: 5px;
    }

    .video-source-badge.url {
      background-color: #6f42c1;
      color: white;
    }

    .video-source-badge.upload {
      background-color: #20c997;
      color: white;
    }

    .uploaded-video-info {
      margin-top: 10px;
      padding: 10px;
      background: #f8f9fa;
      border-radius: 4px;
      border: 1px solid #dee2e6;
    }

    /* Modal backdrop */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      inset: 0;
      background: rgba(0, 0, 0, 0.55);
      backdrop-filter: blur(3px);
      animation: fadeIn 0.25s ease;
    }

    /* Modal box */
    .modal-content {
      background: #ffffff;
      width: 420px;
      max-width: 90%;
      margin: 10% auto;
      border-radius: 10px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
      animation: scaleIn 0.25s ease;
    }

    /* Inner spacing */
    .modal .container {
      padding: 24px;
    }

    /* Title */
    .modal h3,
    .modal h1 {
      margin: 0 0 10px;
      font-size: 20px;
      font-weight: 600;
      color: #1f2937;
    }

    /* Description text */
    .modal p {
      margin: 0 0 20px;
      font-size: 14px;
      color: #6b7280;
    }

    /* Close (×) */
    .modal .close {
      position: absolute;
      top: 16px;
      right: 20px;
      font-size: 26px;
      color: #6b7280;
      cursor: pointer;
      transition: color 0.2s ease;
    }

    .modal .close:hover {
      color: #dc3545;
    }

    /* Button container */
    .modal .clearfix {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    /* Cancel button */
    .modal .cancelbtn {
      background: #e5e7eb;
      color: #374151;
      border: none;
      padding: 8px 14px;
      font-size: 14px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    .modal .cancelbtn:hover {
      background: #d1d5db;
    }

    /* Delete button */
    .modal .deletebtn {
      background: #dc3545;
      color: #fff;
      border: none;
      padding: 8px 16px;
      font-size: 14px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s ease, transform 0.15s ease;
    }

    .modal .deletebtn:hover {
      background: #c82333;
    }

    .modal .deletebtn:active {
      transform: scale(0.95);
    }

    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes scaleIn {
      from {
        transform: scale(0.9);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .publish-card {
      border-radius: 6px;
      box-shadow: 0 1px 4px rgba(16, 24, 40, 0.06);
    }

    .publish-card h4 {
      font-weight: 700;
    }

    .publish-card .badge {
      font-size: 12px;
      padding: 6px 10px;
      border-radius: 20px;
    }

    .publish-card .price-badge {
      font-size: 22px;
    }

    .publish-card .lectures-badge {
      display: flex;
      align-items: center;
      gap: 4px;
    }
  </style>
@endpush

@section('title', 'Admin Review: ' . $course->title)

@section('content')
  <div class="course-preview-container py-4">
    <div class="container-fluid">
      <!-- Course Header -->
      <div class="header-card">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-md-8">
              <div class="d-flex align-items-center mb-3">
                <h1 class="h2 mb-0 mr-3">{{ $course->title }}</h1>
                <span class="status-badge {{ $course->status }}">
                  {{ strtoupper($course->status) }}
                </span>
              </div>
              <p class="lead mb-4" style="opacity: 0.9;">{!! $course->description !!}</p>
              <div class="d-flex flex-wrap gap-3">
                <div class="d-flex align-items-center">
                  <i class="fas fa-user-circle fa-lg mr-2"></i>
                  <strong>Instructor:</strong>
                  <span class="ml-2">{{ $course->user->name ?? 'N/A' }}</span>
                </div>
                <div class="d-flex align-items-center">
                  <i class="fas fa-calendar-alt fa-lg mr-2"></i>
                  <strong>Created:</strong>
                  <span class="ml-2">{{ $course->created_at->format('M d, Y') }}</span>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-right">
              <div class="stat-card d-inline-block">
                <div class="stat-number">
                  @if ($course->pricing && $course->pricing->price > 0)
                    {{ $course->pricing->currency_symbol ?? '$' }}{{ $course->pricing->price }}
                  @else
                    FREE
                  @endif
                </div>
                <div class="text-muted">Course Price</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
          <!-- Rejection Notice -->
          @if ($course->status == 'rejected' && $course->rejection_reason)
            <div class="content-card rejection-box mb-4">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <i class="fas fa-exclamation-triangle fa-2x text-danger mr-3 mt-1"></i>
                  <div>
                    <h5 class="font-weight-bold text-danger mb-2">Course Rejected</h5>
                    <div class="mb-3">
                      <strong>Reason:</strong>
                      <p class="mb-0 mt-1">{{ $course->rejection_reason }}</p>
                    </div>
                    @if ($course->rejected_at)
                      <div class="text-muted">
                        <small>Rejected on:
                          {{ optional(\Carbon\Carbon::parse($course->rejected_at))->format('F d, Y - h:i A') }}</small>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endif

          <!-- Thumbnail Preview -->
          @if ($course->thumbnail)
            <div class="content-card mb-4">
              <div class="card-header">
                <i class="fas fa-image mr-2"></i>Course Thumbnail
              </div>
              <div class="card-body text-center">
                <a href="{{ asset('storage/' . $course->thumbnail) }}" target="_blank" class="d-inline-block">
                  <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Course Thumbnail"
                    class="preview-thumbnail">
                </a>
                <div class="mt-2">
                  <small class="text-muted">Click to view full size</small>
                </div>
              </div>
            </div>
          @endif

          <!-- Course Details -->
          <div class="content-card mb-4">
            <div class="card-header">
              <i class="fas fa-info-circle mr-2"></i>Course Details
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="text-muted small mb-1">Category</label>
                  <div class="d-flex align-items-center">
                    <i class="fas fa-folder text-primary mr-2"></i>
                    <span>{{ $course->category->name ?? 'Not set' }}</span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="text-muted small mb-1">Subcategory</label>
                  <div class="d-flex align-items-center">
                    <i class="fas fa-folder-open text-primary mr-2"></i>
                    <span>{{ $course->subCategory->name ?? 'Not set' }}</span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="text-muted small mb-1">Level</label>
                  <div class="d-flex align-items-center">
                    <i class="fas fa-signal text-info mr-2"></i>
                    <span>{{ ucfirst($course->level ?? 'Not set') }}</span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="text-muted small mb-1">Language</label>
                  <div class="d-flex align-items-center">
                    <i class="fas fa-language text-info mr-2"></i>
                    <span>{{ $course->language ?? 'English' }}</span>
                  </div>
                </div>
              </div>

              @if ($course->objectives)
                <div class="mt-4">
                  <label class="text-muted small mb-2">Learning Objectives</label>
                  <div class="bg-light rounded border p-3">
                    {!! nl2br(e($course->objectives)) !!}
                  </div>
                </div>
              @endif
            </div>
          </div>

          <!-- Curriculum Preview -->
          <div class="content-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                <i class="fas fa-list-ol mr-2"></i>Curriculum Preview
                <span class="badge badge-primary ml-2">{{ $course->sections->count() }} Sections</span>
                @php
                  $totalLectures = 0;
                  $totalVideos = 0;
                  foreach ($course->sections as $section) {
                      $totalLectures += $section->lectures->count();
                      foreach ($section->lectures as $lecture) {
                          if ($lecture->video_url || $lecture->video_file) {
                              $totalVideos++;
                          }
                      }
                  }
                @endphp
                <span class="badge badge-secondary ml-1">{{ $totalLectures }} Lectures</span>
                @if ($totalVideos > 0)
                  <span class="badge badge-info ml-1">{{ $totalVideos }} Videos</span>
                @endif
              </div>
              @if ($totalVideos > 0)
                <button class="btn btn-sm btn-outline-primary" onclick="showAllVideosModal()">
                  <i class="fas fa-video mr-1"></i> View All Videos ({{ $totalVideos }})
                </button>
              @endif
            </div>
            <div class="card-body p-0">
              @forelse ($course->sections->sortBy('order_number') as $section)
                <div class="mb-4">
                  <div class="section-header">
                    <div class="d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">
                        <i class="fas fa-folder mr-2"></i>{{ $section->title }}
                        <span class="badge badge-light ml-2">{{ $section->lectures->count() }} Lectures</span>
                        @php
                          $sectionVideos = 0;
                          foreach ($section->lectures as $lecture) {
                              if ($lecture->video_url || $lecture->video_file) {
                                  $sectionVideos++;
                              }
                          }
                        @endphp
                        @if ($sectionVideos > 0)
                          <span class="badge badge-info ml-1">{{ $sectionVideos }} Videos</span>
                        @endif
                      </h5>
                    </div>
                    @if ($section->description)
                      <p class="small mb-0 mt-2 opacity-90">{{ $section->description }}</p>
                    @endif
                  </div>

                  <div class="px-3">
                    @forelse ($section->lectures->sortBy('order_number') as $lecture)
                      <div class="lecture-item">
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="d-flex align-items-center">
                            <div class="text-primary mr-3">
                              @if ($lecture->video_url || $lecture->video_file)
                                <i class="fas fa-play-circle fa-lg"></i>
                              @else
                                <i class="fas fa-file-alt fa-lg"></i>
                              @endif
                            </div>
                            <div>
                              <h6 class="font-weight-bold mb-1">
                                {{ $lecture->title }}
                                @if ($lecture->video_url || $lecture->video_file)
                                  <span class="video-source-badge {{ $lecture->video_url ? 'url' : 'upload' }}">
                                    {{ $lecture->video_url ? 'URL' : 'Uploaded' }}
                                  </span>
                                @endif
                              </h6>
                              @if ($lecture->description)
                                <p class="text-muted small mb-0">{{ Str::limit($lecture->description, 100) }}</p>
                              @endif
                              @if ($lecture->video_url || $lecture->video_file)
                                <small class="text-muted">
                                  <i class="fas fa-info-circle mr-1"></i>
                                  @if ($lecture->video_url)
                                    External URL
                                  @else
                                    Uploaded File: {{ pathinfo($lecture->video_file, PATHINFO_EXTENSION) }}
                                  @endif
                                </small>
                              @endif
                            </div>
                          </div>
                          <div class="d-flex align-items-center">
                            <!-- Video Preview Button -->
                            @if ($lecture->video_url || $lecture->video_file)
                              @php
                                // Generate correct video URL for both uploaded and URL videos
                                if ($lecture->video_url) {
                                    $videoUrl = $lecture->video_url;
                                    $videoType = 'url';
                                    $videoSource = $lecture->video_url;
                                } else {
                                    $videoUrl = asset('storage/' . $lecture->video_file);
                                    $videoType = 'upload';
                                    $videoSource = $lecture->video_file;
                                }
                              @endphp
                              <button type="button" class="btn btn-sm btn-primary video-preview-btn mr-2"
                                onclick="previewVideo(
                        '{{ $videoUrl }}', 
                        '{{ addslashes($lecture->title) }}',
                        '{{ $videoType }}',
                        '{{ addslashes($videoSource) }}'
                        )">
                                <i class="fas fa-play"></i>
                              </button>
                            @endif

                            <!-- Materials Badge -->
                            @if ($lecture->materials && $lecture->materials->count() > 0)
                              <div class="dropdown">
                                <button class="btn btn-sm btn-info material-badge dropdown-toggle" type="button"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-paperclip mr-1"></i> {{ $lecture->materials->count() }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right material-list p-2">
                                  @foreach ($lecture->materials as $material)
                                    @php
                                      $fileType = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                                      $fileIcons = [
                                          'pdf' => 'file-pdf',
                                          'doc' => 'file-word',
                                          'docx' => 'file-word',
                                          'xls' => 'file-excel',
                                          'xlsx' => 'file-excel',
                                          'ppt' => 'file-powerpoint',
                                          'pptx' => 'file-powerpoint',
                                          'zip' => 'file-archive',
                                          'rar' => 'file-archive',
                                          'jpg' => 'file-image',
                                          'jpeg' => 'file-image',
                                          'png' => 'file-image',
                                          'gif' => 'file-image',
                                      ];
                                      $icon = $fileIcons[$fileType] ?? 'file';
                                    @endphp
                                    <a class="dropdown-item d-flex align-items-center py-2"
                                      href="{{ asset('storage/' . $material->file_path) }}" target="_blank">
                                      <i class="fas fa-{{ $icon }} text-primary mr-2"></i>
                                      <div class="flex-grow-1">
                                        <div class="font-weight-bold">{{ $material->original_filename }}</div>
                                        <small class="text-muted">{{ $material->file_size }} •
                                          {{ strtoupper($fileType) }}</small>
                                      </div>
                                      <i class="fas fa-external-link-alt text-muted ml-2"></i>
                                    </a>
                                    @if (!$loop->last)
                                      <div class="dropdown-divider"></div>
                                    @endif
                                  @endforeach
                                </div>
                              </div>
                            @endif
                          </div>
                        </div>
                      </div>
                    @empty
                      <div class="text-muted py-4 text-center">
                        <i class="fas fa-video-slash fa-2x mb-3"></i>
                        <p>No lectures in this section</p>
                      </div>
                    @endforelse
                  </div>
                </div>
              @empty
                <div class="py-5 text-center">
                  <i class="fas fa-book fa-3x text-muted mb-3"></i>
                  <h5 class="text-muted">No sections added yet</h5>
                </div>
              @endforelse
            </div>
          </div>

          <!-- FAQs -->
          @if ($course->faqs && $course->faqs->count() > 0)
            <div class="content-card mb-4">
              <div class="card-header">
                <i class="fas fa-question-circle mr-2"></i>Frequently Asked Questions
                <span class="badge badge-info ml-2">{{ $course->faqs->count() }} FAQs</span>
              </div>
              <div class="card-body">
                <div class="accordion" id="faqAccordion">
                  @foreach ($course->faqs as $index => $faq)
                    <div class="card mb-2 border">
                      <div class="card-header bg-white p-0" id="heading{{ $index }}">
                        <button
                          class="btn btn-link btn-block d-flex justify-content-between align-items-center p-3 text-left"
                          type="button" data-toggle="collapse" data-target="#collapse{{ $index }}"
                          aria-expanded="false" aria-controls="collapse{{ $index }}">
                          <span class="font-weight-bold text-dark">{{ $faq->question }}</span>
                          <i class="fas fa-chevron-down transition"></i>
                        </button>
                      </div>
                      <div id="collapse{{ $index }}" class="collapse"
                        aria-labelledby="heading{{ $index }}" data-parent="#faqAccordion">
                        <div class="card-body bg-light">
                          {!! nl2br(e($faq->answer)) !!}
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          @endif

          <!-- Requirements Check -->
          <div class="content-card">
            <div class="card-header">
              <i class="fas fa-clipboard-check mr-2"></i>Requirements Validation
            </div>
            <div class="card-body">
              @php
                $requirements = [
                    'title' => (bool) $course->title,
                    'description' => (bool) $course->description,
                    'thumbnail' => (bool) $course->thumbnail,
                    'min_sections' => $course->sections()->count() >= 1,
                    'all_sections_have_lectures' => $course->sections->every(function ($section) {
                        return $section->lectures()->count() >= 1;
                    }),
                    'category_set' => (bool) $course->category_id,
                ];

                $allValid = !in_array(false, $requirements);
              @endphp

              @foreach ($requirements as $key => $valid)
                <div class="requirement-item {{ $valid ? 'valid' : 'invalid' }}">
                  <i
                    class="fas fa-{{ $valid ? 'check-circle text-success' : 'times-circle text-danger' }} fa-lg mr-3"></i>
                  <div class="flex-grow-1">
                    <strong>
                      @switch($key)
                        @case('title')
                          Course Title
                        @break

                        @case('description')
                          Course Description
                        @break

                        @case('thumbnail')
                          Course Thumbnail
                        @break

                        @case('min_sections')
                          Minimum 1 Section
                        @break

                        @case('all_sections_have_lectures')
                          All Sections Have Lectures
                        @break

                        @case('category_set')
                          Category Selected
                        @break
                      @endswitch
                    </strong>
                    @if (!$valid)
                      <div class="small text-muted mt-1">
                        @switch($key)
                          @case('all_sections_have_lectures')
                            @foreach ($course->sections as $section)
                              @if ($section->lectures()->count() < 1)
                                • Section "{{ $section->title }}" has no lectures<br>
                              @endif
                            @endforeach
                          @break
                        @endswitch
                      </div>
                    @endif
                  </div>
                  @if ($valid)
                    <span class="badge badge-success">✓ Pass</span>
                  @else
                    <span class="badge badge-danger">✗ Fail</span>
                  @endif
                </div>
              @endforeach

              <div class="mt-4 text-center">
                @if ($allValid)
                  <div class="alert alert-success">
                    <i class="fas fa-check-circle mr-2"></i>
                    All requirements are met. Course is ready for approval.
                  </div>
                @else
                  <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Some requirements are not met. Course needs adjustments before approval.
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column - Admin Actions -->
        <div class="col-lg-4">
          <!-- Admin Actions -->
          <div class="content-card mb-4">
            <div class="card-header">
              <i class="fas fa-cogs mr-2"></i>Admin Actions
            </div>
            <div class="card-body">
              @if ($course->status == 'pending')
                <form action="{{ route('admin.course_approvals.approve', $course->id) }}" class="publish-btn">
                  @csrf
                  @method('POST')
                  <button type="button" class="btn btn-success w-100 open-delete-modal mb-2"
                    data-title="Publish Course"
                    data-message="Are you sure you want to publish this course? Once published, students can enroll."
                    data-action="publish">
                    <i class="fas fa-check-circle mr-2"></i> Approve Course
                  </button>

                </form>

                <button type="button" class="btn btn-danger btn-block mb-3" data-toggle="modal"
                  data-target="#rejectModal">
                  <i class="fas fa-times-circle mr-2"></i>Reject Course
                </button>
              @endif

              @if ($course->status == 'published')
                <form action="{{ route('admin.course_approvals.reject', $course->id) }}" method="POST"
                  class="mb-3">
                  @csrf
                  @method('POST')
                  <button type="submit" class="btn btn-warning btn-block"
                    onclick="return confirm('Are you sure you want to unpublish this course?')">
                    <i class="fas fa-eye-slash mr-2"></i>Unpublish Course
                  </button>
                </form>
              @endif

              @if ($course->status == 'rejected')
                <form action="{{ route('admin.course_approvals.approve', $course->id) }}" class="mb-3">
                  @csrf

                  <button type="submit" class="btn btn-info btn-block">
                    <i class="fas fa-redo mr-2"></i>Mark for Review
                  </button>
                </form>
              @endif

              <hr class="my-4">

              <h6 class="font-weight-bold mb-3">Quick Actions:</h6>
              <a href="{{ route('teacher.courses.edit', $course->id) }}" target="_blank" class="action-btn">
                <i class="fas fa-edit text-primary mr-3"></i>
                <div>
                  <div class="font-weight-bold">Edit Course</div>
                  <small class="text-muted">Make changes to course details</small>
                </div>
              </a>

              <button class="action-btn" onclick="viewStatistics()">
                <i class="fas fa-chart-bar text-info mr-3"></i>
                <div>
                  <div class="font-weight-bold">View Statistics</div>
                  <small class="text-muted">See enrollment and engagement data</small>
                </div>
              </button>

              <button class="action-btn" onclick="viewInstructor()">
                <i class="fas fa-user-tie text-warning mr-3"></i>
                <div>
                  <div class="font-weight-bold">View Instructor</div>
                  <small class="text-muted">Check instructor profile</small>
                </div>
              </button>

              <button class="action-btn" data-toggle="modal" data-target="#notesModal">
                <i class="fas fa-sticky-note text-success mr-3"></i>
                <div>
                  <div class="font-weight-bold">Add Notes</div>
                  <small class="text-muted">Private notes for review team</small>
                </div>
              </button>
            </div>
          </div>

          <!-- Statistics -->
          <div class="content-card mb-4">
            <div class="card-header">
              <i class="fas fa-chart-pie mr-2"></i>Quick Stats
            </div>
            <div class="card-body">
              <div class="row text-center">
                <div class="col-6 mb-4">
                  <div class="stat-number">{{ $course->sections->count() }}</div>
                  <div class="text-muted small">Sections</div>
                </div>
                <div class="col-6 mb-4">
                  <div class="stat-number">{{ $totalLectures }}</div>
                  <div class="text-muted small">Lectures</div>
                </div>
                <div class="col-6">
                  <div class="stat-number">{{ $course->faqs->count() }}</div>
                  <div class="text-muted small">FAQs</div>
                </div>
                <div class="col-6">
                  @php
                    $totalMaterials = 0;
                    foreach ($course->sections as $section) {
                        foreach ($section->lectures as $lecture) {
                            $totalMaterials += $lecture->materials->count();
                        }
                    }
                  @endphp
                  <div class="stat-number">{{ $totalMaterials }}</div>
                  <div class="text-muted small">Materials</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Video Stats -->
          @if ($totalVideos > 0)
            <div class="content-card mb-4">
              <div class="card-header">
                <i class="fas fa-video mr-2"></i>Video Statistics
              </div>
              <div class="card-body">
                @php
                  $uploadedVideos = 0;
                  $urlVideos = 0;
                  foreach ($course->sections as $section) {
                      foreach ($section->lectures as $lecture) {
                          if ($lecture->video_url) {
                              $urlVideos++;
                          } elseif ($lecture->video_file) {
                              $uploadedVideos++;
                          }
                      }
                  }
                @endphp
                <div class="row text-center">
                  <div class="col-6 mb-3">
                    <div class="stat-number">{{ $uploadedVideos }}</div>
                    <div class="text-muted small">Uploaded Files</div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="stat-number">{{ $urlVideos }}</div>
                    <div class="text-muted small">External URLs</div>
                  </div>
                </div>
                <div class="progress" style="height: 10px;">
                  @if ($totalVideos > 0)
                    <div class="progress-bar bg-success" style="width: {{ ($uploadedVideos / $totalVideos) * 100 }}%">
                      <span class="sr-only">Uploaded {{ $uploadedVideos }}</span>
                    </div>
                    <div class="progress-bar bg-info" style="width: {{ ($urlVideos / $totalVideos) * 100 }}%">
                      <span class="sr-only">URLs {{ $urlVideos }}</span>
                    </div>
                  @endif
                </div>
                <div class="d-flex justify-content-between mt-2">
                  <small><span class="badge badge-success">Uploaded</span></small>
                  <small><span class="badge badge-info">URL</span></small>
                </div>
              </div>
            </div>
          @endif

          <!-- Course Metadata -->
          <div class="content-card">
            <div class="card-header">
              <i class="fas fa-database mr-2"></i>Course Metadata
            </div>
            <div class="card-body">
              <div class="list-group list-group-flush">
                <div class="list-group-item border-0 px-0 py-2">
                  <small class="text-muted d-block">Course ID</small>
                  <code class="cursor-pointer"
                    onclick="copyToClipboard('{{ $course->id }}')">{{ $course->id }}</code>
                </div>
                <div class="list-group-item border-0 px-0 py-2">
                  <small class="text-muted d-block">Created</small>
                  {{ $course->created_at->format('M d, Y - h:i A') }}
                </div>
                <div class="list-group-item border-0 px-0 py-2">
                  <small class="text-muted d-block">Last Updated</small>
                  {{ $course->updated_at->format('M d, Y - h:i A') }}
                </div>
                @if ($course->published_at)
                  <div class="list-group-item border-0 px-0 py-2">
                    <small class="text-muted d-block">Published</small>
                    {{ optional(\Carbon\Carbon::parse($course->published_at))->format('M d, Y - h:i A') }}
                  </div>
                @endif
                @if ($course->admin_notes)
                  <div class="list-group-item border-0 px-0 py-2">
                    <small class="text-muted d-block">Admin Notes</small>
                    <div class="admin-notes small mt-1">
                      {{ $course->admin_notes }}
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Video Preview Modal -->
  <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="videoModalTitle">Video Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0">
          <div class="video-player-wrapper" id="videoPlayer">
            <!-- Video will be loaded here -->
          </div>
          <div class="border-top p-3">
            <div class="video-url-display">
              <strong>Source:</strong>
              <span id="videoSourceType"></span>
              <br>
              <strong>URL/Path:</strong>
              <span id="currentVideoUrl"></span>
            </div>
            <div id="uploadedVideoInfo" class="uploaded-video-info" style="display: none;">
              <strong>File Information:</strong>
              <div id="videoFileInfo"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a id="videoSourceLink" href="#" target="_blank" class="btn btn-primary">
            <i class="fas fa-external-link-alt mr-2"></i>Open Source
          </a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- All Videos Modal -->
  <div class="modal fade" id="allVideosModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">All Course Videos ({{ $totalVideos }})</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="list-group" id="allVideosList">
            <!-- Videos will be loaded here -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Reject Course Modal -->
  <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('admin.course_approvals.reject', $course->id) }}">
          @csrf
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">
              <i class="fas fa-times-circle mr-2"></i>Reject Course
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="text-muted mb-4">Please provide a reason for rejection. This will be shared with the instructor.
            </p>

            <div class="form-group">
              <label for="rejectionReason">Rejection Reason *</label>
              <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="5"
                placeholder="Explain why this course is being rejected..." required>{{ old('rejection_reason') }}</textarea>
            </div>



          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Confirm Rejection</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Approve Modal --}}

  <div id="deleteModal" class="modal">
    <span class="close">&times;</span>

    <div class="modal-content">
      <div class="container">
        <h3 id="deleteModalTitle">Delete</h3>
        <p id="deleteModalMessage">Are you sure?</p>

        <div class="clearfix">
          <button type="button" class="cancelbtn">Cancel</button>
          <button type="button" class="deletebtn">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Review Notes Modal -->
  <div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="" method="POST" id="notesForm">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Review Notes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="adminNotes">Private Notes (Only visible to admins)</label>
              <textarea class="form-control" id="adminNotes" name="admin_notes" rows="8">{{ $course->admin_notes ?? '' }}</textarea>
              <small class="form-text text-muted">These notes are private and will not be shared with the
                instructor.</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Notes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // FAQ Accordion
      $('.accordion .btn-link').click(function() {
        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
      });
    });

    // Video preview function
    function previewVideo(videoUrl, title, videoType, source) {
      if (!videoUrl || videoUrl === '') {
        toastr.error('No video available for this lecture');
        return;
      }

      const modal = $('#videoModal');
      modal.find('#videoModalTitle').text('Preview: ' + title);
      modal.find('#currentVideoUrl').text(source);

      // Set source type
      const sourceType = videoType === 'url' ? 'External URL (YouTube/Vimeo/etc.)' : 'Uploaded File';
      modal.find('#videoSourceType').text(sourceType);

      const videoPlayer = $('#videoPlayer');
      videoPlayer.empty();

      // Set the source link
      let sourceLink = videoUrl;
      if (videoType === 'upload') {
        sourceLink = videoUrl; // Already has full URL with asset('storage/...')
      }
      $('#videoSourceLink').attr('href', sourceLink);

      // Show/hide uploaded video info
      if (videoType === 'upload') {
        $('#uploadedVideoInfo').show();
        $('#videoFileInfo').html(`
        <div>Storage Path: ${source}</div>
        <div>Full URL: ${videoUrl}</div>
        <div>File Type: ${videoUrl.split('.').pop().toUpperCase()}</div>
      `);
      } else {
        $('#uploadedVideoInfo').hide();
        $('#videoFileInfo').empty();
      }

      // Handle YouTube URLs
      if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
        let videoId = '';
        if (videoUrl.includes('youtube.com')) {
          const urlParams = new URLSearchParams(new URL(videoUrl).search);
          videoId = urlParams.get('v');
        } else if (videoUrl.includes('youtu.be')) {
          videoId = videoUrl.split('/').pop().split('?')[0];
        }

        if (videoId) {
          const embedUrl = `https://www.youtube.com/embed/${videoId}?rel=0&modestbranding=1&showinfo=0&autoplay=1`;
          videoPlayer.html(`
          <iframe src="${embedUrl}" 
                  frameborder="0" 
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                  allowfullscreen
                  autoplay="1">
          </iframe>
        `);
        } else {
          videoPlayer.html('<p class="text-center p-5">Unable to load YouTube video</p>');
        }
      }
      // Handle Vimeo URLs
      else if (videoUrl.includes('vimeo.com')) {
        const videoId = videoUrl.split('/').pop().split('?')[0];
        const embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
        videoPlayer.html(`
        <iframe src="${embedUrl}" 
                frameborder="0" 
                allow="autoplay; fullscreen; picture-in-picture" 
                allowfullscreen
                autoplay="1">
        </iframe>
      `);
      }
      // Handle direct video files (uploaded files)
      else {
        // Check if it's a video file by extension
        const videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi', 'wmv', 'flv', 'mkv'];
        const fileExtension = videoUrl.split('.').pop().toLowerCase();
        const isVideoFile = videoExtensions.includes(fileExtension);

        if (isVideoFile) {
          const videoHtml = `
          <video controls autoplay style="width:100%; height:100%;">
            <source src="${videoUrl}" type="video/${fileExtension === 'mov' ? 'quicktime' : fileExtension}">
            Your browser does not support the video tag.
          </video>
        `;
          videoPlayer.html(videoHtml);
        } else {
          // If not a recognized video format, show download link
          videoPlayer.html(`
          <div class="text-center p-5">
            <i class="fas fa-file-video fa-4x text-muted mb-3"></i>
            <h5>Uploaded Video File</h5>
            <p class="text-muted">This is an uploaded video file that can be downloaded.</p>
            <a href="${videoUrl}" target="_blank" class="btn btn-primary mt-3" download>
              <i class="fas fa-download mr-2"></i>Download Video File
            </a>
          </div>
        `);
        }
      }

      modal.modal('show');
    }

    // Show all videos in a modal
    function showAllVideosModal() {
      // Collect all videos from the course
      @php
        $allVideos = [];
        foreach ($course->sections as $section) {
            foreach ($section->lectures as $lecture) {
                if ($lecture->video_url || $lecture->video_file) {
                    if ($lecture->video_url) {
                        $videoUrl = $lecture->video_url;
                        $videoType = 'url';
                        $videoSource = $lecture->video_url;
                    } else {
                        $videoUrl = asset('storage/' . $lecture->video_file);
                        $videoType = 'upload';
                        $videoSource = $lecture->video_file;
                    }

                    $allVideos[] = [
                        'title' => $lecture->title,
                        'url' => $videoUrl,
                        'type' => $videoType,
                        'source' => $videoSource,
                        'section' => $section->title,
                        'description' => $lecture->description,
                        'file_extension' => $lecture->video_file ? pathinfo($lecture->video_file, PATHINFO_EXTENSION) : null,
                    ];
                }
            }
        }
      @endphp

      const videos = @json($allVideos);

      if (videos.length === 0) {
        toastr.info('No videos found in this course');
        return;
      }

      // Populate the modal with video list
      const videosList = $('#allVideosList');
      videosList.empty();

      videos.forEach((video, index) => {
        const videoTypeBadge = video.type === 'url' ?
          '<span class="badge badge-info ml-1">URL</span>' :
          `<span class="badge badge-success ml-1">Uploaded (${video.file_extension?.toUpperCase() || 'VID'})</span>`;

        const videoItem = `
        <div class="list-group-item all-videos-item">
          <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
              <div class="font-weight-bold mb-1">
                ${video.title}
                ${videoTypeBadge}
              </div>
              <div class="d-flex justify-content-between mb-2">
                <small class="text-muted">
                  <i class="fas fa-folder mr-1"></i>${video.section}
                </small>
                <small class="text-muted">
                  <i class="fas fa-${video.type === 'url' ? 'link' : 'file-video'} mr-1"></i>
                  ${video.type === 'url' ? 'External URL' : 'Uploaded File'}
                </small>
              </div>
              ${video.description ? `<p class="small text-muted mb-2">${video.description.substring(0, 100)}${video.description.length > 100 ? '...' : ''}</p>` : ''}
              <div class="video-url-display small mb-2">
                <strong>Source:</strong> ${video.source.length > 60 ? video.source.substring(0, 60) + '...' : video.source}
              </div>
            </div>
            <div class="ml-3 d-flex flex-column">
              <button class="btn btn-sm btn-primary mb-1" 
                      onclick="previewVideo('${video.url}', '${video.title.replace(/'/g, "\\'")}', '${video.type}', '${video.source.replace(/'/g, "\\'")}')">
                <i class="fas fa-play mr-1"></i> Play
              </button>
              <a href="${video.url}" target="_blank" class="btn btn-sm btn-outline-primary" ${video.type === 'upload' ? 'download' : ''}>
                <i class="fas fa-external-link-alt mr-1"></i> ${video.type === 'url' ? 'Open URL' : 'Download'}
              </a>
            </div>
          </div>
        </div>
      `;
        videosList.append(videoItem);
      });

      $('#allVideosModal').modal('show');
    }

    // Copy to clipboard
    function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(() => {
        toastr.success('Course ID copied to clipboard');
      }).catch(err => {
        console.error('Failed to copy: ', err);
        toastr.error('Failed to copy to clipboard');
      });
    }

    // View statistics
    function viewStatistics() {
      toastr.info('Statistics feature coming soon!');
    }

    // View instructor
    function viewInstructor() {
      const instructorId = {{ $course->user->id ?? 'null' }};
      if (instructorId) {
        window.open(`/admin/users/edit${instructorId}`, '_blank');
      } else {
        toastr.warning('Instructor information not available');
      }
    }

    // Handle notes form submission
    $('#notesForm').on('submit', function(e) {
      e.preventDefault();

      const form = $(this);
      const formData = form.serialize();

      $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message || 'Notes saved successfully');
            $('#notesModal').modal('hide');
            location.reload();
          } else {
            toastr.error(response.message || 'Failed to save notes');
          }
        },
        error: function(xhr) {
          toastr.error('An error occurred while saving notes');
        }
      });
    });

    // Reset video player when modal is closed
    $('#videoModal').on('hidden.bs.modal', function() {
      $('#videoPlayer').empty();
      $('#uploadedVideoInfo').hide();
      $('#videoFileInfo').empty();
    });

    // Add Toastr notifications
    @if (session('success'))
      toastr.success('{{ session('success') }}');
    @endif

    @if (session('error'))
      toastr.error('{{ session('error') }}');
    @endif

    @if (session('warning'))
      toastr.warning('{{ session('warning') }}');
    @endif



    let currentForm = null;
    const modal = document.getElementById('deleteModal'); // your modal
    const actionBtn = modal.querySelector('.deletebtn'); // modal action button

    // Open modal on any trigger
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.open-delete-modal');
      if (!btn) return;

      currentForm = btn.closest('form');

      // Set modal title/message
      document.getElementById('deleteModalTitle').textContent =
        btn.dataset.title || 'Action';
      document.getElementById('deleteModalMessage').textContent =
        btn.dataset.message || 'Are you sure?';

      // Update modal button based on action
      const action = btn.dataset.action || 'delete';
      if (action === 'delete') {
        actionBtn.textContent = 'Delete';
        actionBtn.style.backgroundColor = '#dc3545';
        actionBtn.style.color = '#fff';
      } else if (action === 'publish') {
        actionBtn.textContent = 'Publish';
        actionBtn.style.backgroundColor = '#16a34a';
        actionBtn.style.color = '#fff';
      }

      modal.style.display = 'block';
    });

    // Close modal
    modal.querySelector('.close').onclick =
      modal.querySelector('.cancelbtn').onclick = () => {
        modal.style.display = 'none';
        currentForm = null;
      };

    // Submit form when modal action button is clicked
    actionBtn.onclick = () => {
      if (currentForm) currentForm.submit();
    };

    // Close modal when clicking outside
    window.onclick = e => {
      if (e.target === modal) modal.style.display = 'none';
    };
  </script>
@endpush

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endpush
