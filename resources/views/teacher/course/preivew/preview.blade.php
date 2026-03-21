@extends('teacher.layouts.course-builder')
@push('styles')
  <style>
    .card {
      box-shadow: 0 0 1px rgba(0, 0, 0, .1), 0 2px 4px rgba(0, 0, 0, .02);
      border-radius: 8px;
    }

    .card-header {
      border-radius: 8px 8px 0 0 !important;
    }

    .list-group-item {
      border-left: 0;
      border-right: 0;
      transition: background-color 0.2s;
    }

    .list-group-item:hover {
      background-color: #f8f9fa;
    }

    .btn-link {
      text-decoration: none;
      position: relative;
    }

    .btn-link:hover {
      text-decoration: none;
      color: #007bff !important;
    }

    .badge {
      font-weight: 500;
      padding: 0.35em 0.65em;
      font-size: 0.85em;
    }

    .accordion .card-header {
      background-color: #fff;
      border-bottom: 1px solid rgba(0, 0, 0, .125);
    }

    .accordion .btn-link:after {
      content: '';
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      transition: transform 0.3s;
    }

    .accordion .btn-link[aria-expanded="true"]:after {
      transform: translateY(-50%) rotate(180deg);
    }
  </style>
@endpush
@section('title', 'Preview: ' . $course->title)

@section('content')
  <div class="container-fluid py-4">
    <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header border-bottom-0 bg-white">
            <div class="d-flex justify-content-between align-items-center">
              <h2 class="card-title text-dark font-weight-bold mb-0">{{ $course->title }}</h2>
              <div>
                @if ($course->status == 'published')
                  <span class="badge badge-success">Published</span>
                @elseif($course->status == 'pending')
                  <span class="badge badge-warning">Pending Review</span>
                @elseif($course->status == 'rejected')
                  <span class="badge badge-danger">Rejected</span>
                @else
                  <span class="badge badge-secondary">Draft</span>
                @endif
              </div>
            </div>
          </div>

          <div class="card-body">
            <!-- Course Thumbnail -->
            @if ($course->thumbnail)
              <div class="mb-4">
                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                  class="img-fluid w-100 rounded" style="max-height: 400px; object-fit: cover;">
              </div>
            @endif

            <!-- Course Info -->
            <div class="row mb-4">
              <div class="col-md-8">
                <p class="text-muted mb-3">{!! $course->description !!}</p>

                <div class="d-flex mb-3 flex-wrap gap-2">
                  @if ($course->category)
                    <span class="badge badge-light border">
                      <i class="fas fa-folder mr-1"></i> {{ $course->category->name }}
                    </span>
                  @endif

                  @if ($course->subCategory)
                    <span class="badge badge-light border">
                      <i class="fas fa-folder-open mr-1"></i> {{ $course->subCategory->name }}
                    </span>
                  @endif

                  @if ($course->level)
                    <span class="badge badge-info">
                      <i class="fas fa-signal mr-1"></i> {{ ucfirst($course->level) }}
                    </span>
                  @endif
                </div>
              </div>

              <div class="col-md-4">
                <div class="card border">
                  <div class="card-body text-center">
                    <h4 class="text-dark mb-3">Course Price</h4>
                    @if ($course->pricing?->price > 0)
                      <div class="display-4 font-weight-bold text-primary mb-2">
                        {{ $course->pricing->currency_symbol }}{{ $course->pricing->price }}
                      </div>
                      <small class="text-muted">{{ $course->pricing->currency }}</small>
                    @else
                      <div class="display-4 font-weight-bold text-success mb-2">Free</div>
                      <small class="text-muted">No payment required</small>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            @if ($course->status == 'rejected' && $course->rejection_reason)
              <div class="alert alert-danger">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle mr-2"></i>Course Rejected</h5>
                <p class="mb-0"><strong>Reason:</strong> {{ $course->rejection_reason }}</p>
                @if ($course->rejected_at)
                  <small class="text-muted">Rejected on: {{ $course->rejected_at->format('M d, Y') }}</small>
                @endif
              </div>
            @endif

            @if ($course->published_at)
              <div class="alert alert-info">
                <i class="fas fa-calendar-check mr-2"></i>
                Published on: {{ \Carbon\Carbon::parse($course->published_at)->format('M d, Y - h:i A') }}
              </div>
            @endif


            <hr class="my-4">

            <!-- Curriculum -->
            <h4 class="text-dark font-weight-bold mb-4">
              <i class="fas fa-list-ol mr-2"></i>Curriculum
            </h4>

            @forelse ($course->sections->sortBy('order_number') as $section)
              <div class="card mb-3 border">
                <div class="card-header bg-light">
                  <h5 class="font-weight-bold mb-0">
                    <i class="fas fa-folder mr-2"></i>{{ $section->title }}
                  </h5>
                </div>

                <div class="list-group list-group-flush">
                  @forelse ($section->lectures->sortBy('order_number') as $lecture)
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                      <div class="d-flex align-items-center">
                        <div class="text-muted mr-3">
                          <i class="fas fa-play-circle"></i>
                        </div>
                        <div>
                          <h6 class="mb-1">{{ $lecture->title }}</h6>
                          @if ($lecture->description)
                            <p class="text-muted small mb-0">{{ Str::limit($lecture->description, 100) }}</p>
                          @endif
                        </div>
                      </div>
                      <div>
                        @if ($lecture->video_url || $lecture->video_file)
                          <span class="badge badge-light text-success border">
                            <i class="fas fa-video mr-1"></i> Video
                          </span>
                        @endif

                        @if ($lecture->materials && $lecture->materials->count() > 0)
                          <span class="badge badge-light text-info ml-1 border">
                            <i class="fas fa-paperclip mr-1"></i> {{ $lecture->materials->count() }}
                          </span>
                        @endif

                        <span class="badge badge-secondary ml-2">Preview</span>
                      </div>
                    </div>
                  @empty
                    <div class="list-group-item text-muted py-3 text-center">
                      No lectures in this section
                    </div>
                  @endforelse
                </div>
              </div>
            @empty
              <div class="alert alert-warning">
                <i class="fas fa-exclamation-circle mr-2"></i>
                No sections added to this course yet.
              </div>
            @endforelse

            <hr class="my-4">

            <!-- FAQs -->
            @if ($course->faqs && $course->faqs->count() > 0)
              <h4 class="text-dark font-weight-bold mb-4">
                <i class="fas fa-question-circle mr-2"></i>Frequently Asked Questions
              </h4>

              <div class="accordion" id="faqAccordion">
                @foreach ($course->faqs as $index => $faq)
                  <div class="card mb-2 border">
                    <div class="card-header bg-white p-0" id="heading{{ $index }}">
                      <h5 class="mb-0">
                        <button
                          class="btn btn-link text-dark font-weight-bold w-100 d-flex justify-content-between align-items-center px-4 py-3 text-left"
                          type="button" data-toggle="collapse" data-target="#collapse{{ $index }}"
                          aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                          aria-controls="collapse{{ $index }}">
                          {{ $faq->question }}
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </h5>
                    </div>
                    <div id="collapse{{ $index }}" class="{{ $index == 0 ? 'show' : '' }} collapse"
                      aria-labelledby="heading{{ $index }}" data-parent="#faqAccordion">
                      <div class="card-body text-muted">
                        {{ $faq->answer }}
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

            <!-- Course Requirements Check -->
            @if (!$course->canBeSubmitted())
              <div class="alert alert-warning mt-4">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle mr-2"></i>Course Requirements Not Met</h5>
                <p class="mb-2">To submit this course for review, please ensure:</p>
                <ul class="mb-0">
                  @if (!$course->title || !$course->description || !$course->thumbnail)
                    <li>Title, description, and thumbnail are required</li>
                  @endif
                  @if ($course->sections()->count() < 1)
                    <li>At least one course section is required</li>
                  @endif
                  @foreach ($course->sections as $section)
                    @if ($section->lectures()->count() < 1)
                      <li>Section "{{ $section->title }}" has no lectures</li>
                    @endif
                  @endforeach
                </ul>
              </div>
            @endif
          </div>

          <!-- Footer Actions -->
          <div class="card-footer border-top bg-white">
            <div class="d-flex justify-content-between">
              <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-edit mr-2"></i>Edit Course
              </a>

              @if ($course->canBeSubmitted() && $course->status == 'draft')
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
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Course Statistics</h5>
          </div>
          <div class="card-body">
            <div class="list-group list-group-flush">
              <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                <span class="text-muted">Total Sections</span>
                <span class="badge badge-primary badge-pill">{{ $course->sections->count() }}</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                <span class="text-muted">Total Lectures</span>
                <span class="badge badge-primary badge-pill">{{ $course->lectures->count() }}</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                <span class="text-muted">FAQs</span>
                <span class="badge badge-primary badge-pill">{{ $course->faqs->count() }}</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                <span class="text-muted">Level</span>
                <span class="badge badge-info">{{ ucfirst($course->level ?? 'Not set') }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="card mt-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Quick Actions</h5>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <a href="" class="btn btn-outline-secondary text-left">
                <i class="fas fa-list mr-2"></i>Manage Sections
              </a>
              <a href="" class="btn btn-outline-secondary text-left">
                <i class="fas fa-question-circle mr-2"></i>Manage FAQs
              </a>
              <a href="" class="btn btn-outline-secondary text-left">
                <i class="fas fa-dollar-sign mr-2"></i>Edit Pricing
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      // Auto-collapse other FAQ items when one is opened
      $('.accordion .btn-link').click(function() {
        $('.accordion .btn-link').not(this).each(function() {
          if ($(this).attr('aria-expanded') === 'true') {
            $(this).click();
          }
        });
      });
    });
  </script>
@endpush
