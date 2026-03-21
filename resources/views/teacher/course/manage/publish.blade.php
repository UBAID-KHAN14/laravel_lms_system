@php
  $hasCourse = Auth::user()->courses()->exists();
  $sections_count = $course->sections()->count();
  $lectures_count = $course->sections()->withCount('lectures')->get()->sum('lectures_count');
  $faqs_count = $course->faqs()->count();
  $readySteps = [
      'basic' => $hasCourse,
      'curriculum' => $sections_count > 0 && $lectures_count > 0,
      'pricing' => !empty($course->pricing) || empty($course->pricing),
      'faqs' => $faqs_count > 0,
  ];

  $completedCount = collect($readySteps)->filter()->count();
  $totalSteps = count($readySteps);
  $isReadyToPublish = $completedCount === $totalSteps;
@endphp

@section('page-title')
  Publish Course
@endsection

@push('css')
  <style>
    .course-thumb {
      width: 100%;
      height: 260px;
      object-fit: cover;
      border-radius: 6px;
    }

    .price-badge {
      font-weight: 700;
      color: #0ea5a4;
      font-size: 20px;
    }

    .meta-line {
      color: #6b7280;
      font-size: 14px;
    }

    .lectures-badge {
      background: #0ea5a4;
      color: #fff;
      padding: 6px 10px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 13px;
    }

    .preview-btn {
      border: 1px solid #3b82f6;
      color: #3b82f6;
      background: transparent;
    }

    .sidebar-card {
      border-radius: 6px;
      box-shadow: 0 1px 4px rgba(16, 24, 40, 0.04);
    }

    .stat-number {
      font-size: 28px;
      font-weight: 700;
      color: #0ea5a4;
    }

    .checklist-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 0;
      border-top: 1px solid #eef2f7;
    }

    .progress-wrap {
      height: 10px;
      background: #f3f4f6;
      border-radius: 8px;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      background: #10b981;
      width: 75%;
    }

    @media (max-width: 991px) {
      .course-thumb {
        height: 180px;
      }
    }

    .course-status-card {
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      padding: 16px;
      background: #ffffff;
    }

    .status-row {
      display: flex;
      gap: 14px;
      align-items: flex-start;
    }

    .status-icon {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }

    .status-text h6 {
      margin: 0;
      font-weight: 600;
      font-size: 15px;
    }

    .status-text p {
      margin: 2px 0 0;
      font-size: 13px;
      color: #6b7280;
    }

    .status-pending {
      background: #fff7ed;
      color: #f97316;
    }

    .status-approved {
      background: #ecfdf5;
      color: #16a34a;
    }

    .status-draft {
      background: #eff6ff;
      color: #2563eb;
    }

    .publish-btn {
      margin-top: 14px;
    }

    .publish-btn button {
      font-weight: 600;
    }

    .alert {
      font-size: 14px;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-lg-8">
      <div class="card publish-card mb-4">
        <div class="card-body">
          <div class="row g-3 align-items-center">

            {{-- Thumbnail --}}
            <div class="col-md-4 col-lg-3">
              @if (!empty($course->thumbnail))
                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="thumb" class="course-thumb">
              @else
                <img src="{{ asset('public/default_slider_images/default.jpg') }}" alt="thumb" class="course-thumb">
              @endif
            </div>

            {{-- Content --}}
            <div class="col-md-8 col-lg-9">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                  <h4 class="mb-1">{{ $course->title ?? 'Course Title' }}</h4>
                  <div class="meta-line">
                    <i class="fa fa-user me-1"></i>
                    Created by {{ Auth::user()->name ?? 'Khan' }}
                  </div>
                </div>

                {{-- Status Badge --}}
                @if ($course->status === 'published')
                  <span class="badge bg-success">Published</span>
                @elseif ($course->status === 'pending')
                  <span class="badge bg-primary">Pending</span>
                @elseif ($course->status === 'rejected')
                  <span class="badge bg-danger">Rejected</span>
                @else
                  <span class="badge bg-warning">Draft</span>
                @endif
              </div>

              {{-- Description --}}
              <p class="meta-line mb-3">
                {!! Str::limit($course->description ?? 'No description added yet.', 140) !!}
              </p>

              {{-- Stats --}}
              <div class="d-flex align-items-center mb-3 flex-wrap gap-3" style="justify-content: space-between">
                <div class="price-badge">
                  @if ($course->pricing?->price > 0)
                    <span class="price-badge">
                      {{ $course->pricing->currency_symbol }}
                      {{ number_format($course->pricing->price, 2) }}
                    </span>
                  @else
                    <span class="badge bg-success px-3 py-2">
                      Free
                    </span>
                  @endif


                </div>

                <div class="d-flex align-items-center">
                  <div class="badge gap-2 bg-black">
                    <i class="fas fa-play-circle me-1"></i>
                    {{ $lectures_count ?? 0 }} Lectures
                  </div>

                  <div class="badge bg-primary meta-line">
                    <i class="fas fa-layer-group me-1"></i>
                    {{ $sections_count ?? 0 }} Sections
                  </div>
                </div>
              </div>

              {{-- Actions --}}
              <div class="d-flex gap-2">
                <a href="{{ route('teacher.courses.preview', $course->id) }}" target="_blank"
                  class="btn preview-btn btn-sm me-2">
                  <i class="fa fa-eye me-1"></i> Preview Course
                </a>

                <a href="{{ route('teacher.courses.manage', $course->id) }}"
                  class="btn btn-outline-secondary btn-sm ml-1">
                  <i class="fas fa-edit me-1"></i> Edit Course
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="card sidebar-card mb-4">
        <div class="card-body">
          <h5 class="mb-3">Publishing Checklist</h5>
          <div class="progress-wrap mb-3">
            <div class="progress-fill" style="width: {{ ($completedCount / $totalSteps) * 100 }}%"></div>
          </div>

          <div class="meta-line mb-3">
            {{ $completedCount }} of {{ $totalSteps }} steps completed
          </div>


          <div class="checklist-item">
            <div>
              <strong>
                <i class="fas fa-circle-info me-1"></i> Basic Information
              </strong>
              <div class="meta-line">Title, description, thumbnail</div>
            </div>

            @if ($readySteps['basic'])
              <span class="text-success fw-semibold">
                <i class="fas fa-check-circle me-1"></i> Completed
              </span>
            @else
              <a href="{{ route('teacher.courses.manage', $course->id) }}?tab=basic"
                class="btn btn-outline-danger btn-sm">
                <i class="fas fa-exclamation-circle"></i> Fix
              </a>
            @endif
          </div>

          <div class="checklist-item">
            <div>
              <strong>
                <i class="fas fa-circle-info me-1"></i> Curriculum
              </strong>
              <div class="meta-line">Sections, and lectures with content</div>
            </div>

            @if ($readySteps['curriculum'])
              <span class="text-success fw-semibold">
                <i class="fas fa-check-circle me-1"></i> Completed
              </span>
            @else
              <a href="{{ route('teacher.courses.manage', $course->id) }}?tab=curriculum"
                class="btn btn-outline-danger btn-sm">
                <i class="fas fa-exclamation-circle"></i> Fix
              </a>
            @endif
          </div>

          <div class="checklist-item">
            <div>
              <strong>
                <i class="fas fa-circle-info me-1"></i> Pricing
              </strong>
              <div class="meta-line">Set Course Pricing</div>
            </div>

            @if ($readySteps['pricing'])
              <span class="text-success fw-semibold">
                <i class="fas fa-check-circle me-1"></i> Completed
              </span>
            @else
              <a href="{{ route('teacher.courses.manage', $course->id) }}?tab=pricing"
                class="btn btn-outline-danger btn-sm">
                <i class="fas fa-exclamation-circle"></i> Fix
              </a>
            @endif
          </div>

          <div class="checklist-item">
            <div>
              <strong>
                <i class="fas fa-circle-info me-1"></i> FAQs
              </strong>
              <div class="meta-line">Frequently Asked Questions</div>
            </div>

            @if ($readySteps['faqs'])
              <span class="text-success fw-semibold">
                <i class="fas fa-check-circle me-1"></i> Completed
              </span>
            @else
              <a href="{{ route('teacher.courses.manage', $course->id) }}?tab=faqs"
                class="btn btn-outline-danger btn-sm">
                <i class="fas fa-exclamation-circle"></i> Fix
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card sidebar-card mb-3">
        <div class="card-body">

          @if ($isReadyToPublish)
            <div class="alert alert-success d-flex align-items-center gap-2">
              <i class="fas fa-check-circle"></i>
              <span>Your course is ready to be published 🎉</span>
            </div>

            <div class="course-status-card">
              @if ($course->status === 'pending')
                <div class="status-row">
                  <div class="status-icon status-pending">
                    <i class="fas fa-hourglass-half"></i>
                  </div>
                  <div class="status-text">
                    <h6>Under Review</h6>
                    <p>Your course is published and waiting for admin approval.</p>
                  </div>
                </div>
              @elseif ($course->status === 'published')
                <div class="status-row">
                  <div class="status-icon status-approved">
                    <i class="fas fa-check-circle"></i>
                  </div>
                  <div class="status-text">
                    <h6>Approved & Live</h6>
                    <p>Your course is approved and students can enroll now.</p>
                  </div>
                </div>
              @else
                <div class="status-row">
                  <div class="status-icon status-draft">
                    <i class="fas fa-pencil-alt"></i>
                  </div>
                  <div class="status-text">
                    <h6>Draft Mode</h6>
                    <p>Your course is ready. Publish it to make it live.</p>
                  </div>
                </div>

                <form action="{{ route('teacher.course.submit', $course->id) }}" class="publish-btn">
                  @csrf
                  <button type="button" class="btn btn-success w-100 open-delete-modal" data-title="Publish Course"
                    data-message="Are you sure you want to publish this course? Once published, students can enroll."
                    data-action="publish">
                    <i class="fas fa-rocket me-1"></i> Publish Course
                  </button>
                </form>
              @endif
            </div>
          @else
            <div class="alert alert-warning d-flex align-items-center gap-2">
              <i class="fas fa-exclamation-triangle"></i>
              <span>Complete all required steps to publish your course.</span>
            </div>

            <button class="btn btn-secondary w-100" disabled>
              <i class="fas fa-lock me-1"></i> Publish Locked
            </button>
          @endif


          <a href="{{ route('teacher.courses.preview', $course->id) }}" target="_blank"
            class="btn btn-outline-primary w-100 mt-2">
            <i class="fas fa-eye me-1"></i> Preview Course
          </a>

        </div>
      </div>

      <div class="card sidebar-card">
        <div class="card-body">
          <h6 class="mb-3">Course Stats</h6>

          <div class="row text-center">
            {{-- Sections --}}
            <div class="col-4">
              <div class="stat-number {{ $sections_count > 0 ? 'text-success' : 'text-danger' }}">
                {{ $sections_count ?? 0 }}
              </div>
              <div class="meta-line">
                <i class="fas fa-layer-group me-1"></i> Sections
              </div>
              @if (($sections_count ?? 0) == 0)
                <small class="text-danger d-block mt-1">Required</small>
              @endif
            </div>

            {{-- Lectures --}}
            <div class="col-4">
              <div class="stat-number {{ $lectures_count > 0 ? 'text-success' : 'text-warning' }}">
                {{ $lectures_count ?? 0 }}
              </div>
              <div class="meta-line">
                <i class="fas fa-play-circle me-1"></i> Lectures
              </div>
              @if (($lectures_count ?? 0) == 0)
                <small class="text-warning d-block mt-1">Add content</small>
              @endif
            </div>

            {{-- FAQs --}}
            <div class="col-4">
              <div class="stat-number {{ $faqs_count > 0 ? 'text-success' : 'text-muted' }}">
                {{ $faqs_count ?? 0 }}
              </div>
              <div class="meta-line">
                <i class="fas fa-question-circle me-1"></i> FAQs
              </div>
              @if (($faqs_count ?? 0) == 0)
                <small class="text-muted d-block mt-1">Optional</small>
              @endif
            </div>
          </div>

          {{-- Publish readiness hint --}}
          <hr class="my-3">

          @if (($sections_count ?? 0) > 0 && ($lectures_count ?? 0) > 0)
            <div class="text-success fw-semibold text-center">
              <i class="fas fa-check-circle me-1"></i> Ready to publish
            </div>
          @else
            <div class="text-danger fw-semibold text-center">
              <i class="fas fa-exclamation-circle me-1"></i> Complete required items
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script>
    // Small client-side UI helpers can go here later.
  </script>
@endpush
