@php
  $hasCourse = Auth::user()->courses()->exists();
  $sectionsCount = $course->sections()->count();
  $lecturesCount = $course->sections()->withCount('lectures')->get()->sum('lectures_count');
  $materialsCount = \App\Models\Teacher\Course\LectureMaterial::whereHas('lecture.section', function ($q) use (
      $course,
  ) {
      $q->where('course_id', $course->id);
  })->count();

  $faqsCount = $course->faqs()->count();

  $canPublish = $hasCourse && $lecturesCount && $materialsCount && $faqsCount && $sectionsCount;
  $isPublished = !is_null($course->published_at);
@endphp

{{-- logo and course builder and make the icon and text center --}}
<div class="d-flex align-items-center justify-content-center py-3">
  <h5 class="mb-0 text-center">
    <i class="fas fa-chalkboard-teacher"></i>
    Course Builder
  </h5>
</div>


<ul class="nav nav-pills nav-sidebar flex-column">

  <li class="nav-item">
    <a href="{{ route('teacher.courses.manage', $course->id) }}?tab=basic"
      class="nav-link {{ request('tab', 'basic') === 'basic' ? 'active' : '' }}">
      <i class="nav-icon fas fa-circle-info"></i>

      <p class="d-flex align-items-center w-100 nav-text">
        Basic Info
        @if ($hasCourse > 0)
          <span class="badge nav-badge badge-check">
            <i class="fas fa-check"></i>
          </span>
        @endif
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ $hasCourse ? route('teacher.courses.manage', $course->id) . '?tab=curriculum' : 'javascript:void(0)' }}"
      class="nav-link {{ request('tab') === 'curriculum' ? 'active' : '' }} {{ !$hasCourse ? 'disabled-link' : '' }}">
      <i class="nav-icon fas fa-layer-group"></i>
      <p class="d-flex align-items-center w-100 nav-text">
        Curriculum

        @if ($sectionsCount > 0)
          <span class="badge nav-badge badge-check">
            <i class="fas fa-check"></i>
          </span>
        @else
          <span class="badge nav-badge">
            <i class="fas fa-dot-circle"></i>
          </span>
        @endif
      </p>
    </a>
  </li>




  <li class="nav-item">
    <a href="{{ $sectionsCount ? route('teacher.courses.manage', $course->id) . '?tab=materials' : 'javascript:void(0)' }}"
      class="nav-link {{ request('tab') === 'materials' ? 'active' : '' }} {{ !$sectionsCount ? 'disabled-link' : '' }}">
      <i class="nav-icon fas fa-file-lines"></i>

      <p class="d-flex align-items-center w-100">
        Lecture Materials

        @if ($materialsCount > 0)
          <span class="badge nav-badge badge-count">
            {{ $materialsCount }}
          </span>
        @else
          <span class="badge nav-badge">
            <i class="fas fa-dot-circle"></i>
          </span>
        @endif
      </p>
    </a>
  </li>


  <li class="nav-item">
    <a href="{{ $hasCourse ? route('teacher.courses.manage', $course->id) . '?tab=faqs' : 'javascript:void(0)' }}"
      class="nav-link {{ request('tab') === 'faqs' ? 'active' : '' }} {{ !$hasCourse ? 'disabled-link' : '' }}">
      <i class="nav-icon fas fa-circle-question"></i>


      <p class="d-flex align-items-center w-100">
        FAQs

        @if ($faqsCount > 0)
          <span class="badge nav-badge badge-count">
            {{ $faqsCount }}
          </span>
        @else
          <span class="badge nav-badge">
            <i class="fas fa-dot-circle"></i>
          </span>
        @endif
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ $sectionsCount ? route('teacher.courses.manage', $course->id) . '?tab=pricing' : 'javascript:void(0)' }}"
      class="nav-link {{ request('tab') === 'pricing' ? 'active' : '' }} {{ !$sectionsCount ? 'disabled-link' : '' }}">
      <i class="nav-icon fas fa-tags"></i>
      <p class="d-flex align-items-center w-100">
        Pricing
        @if ($course->pricing)
          <span class="badge nav-badge badge-check">
            <i class="fas fa-check"></i>
          </span>
        @else
          <span class="badge nav-badge">
            <i class="fas fa-dot-circle"></i>
          </span>
        @endif
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ $canPublish ? route('teacher.courses.manage', $course->id) . '?tab=publish' : '#' }}"
      class="nav-link {{ request('tab') === 'publish' ? 'active' : '' }} {{ !$canPublish ? 'disabled-link' : '' }}"
      @if (!$canPublish) aria-disabled="true" @endif>
      <i class="nav-icon fas fa-rocket"></i>


      <p class="d-flex align-items-center w-100 mb-0">
        Publish
        @if ($isPublished)
          <span class="badge nav-badge badge-check ms-auto">
            <i class="fas fa-check"></i>
          </span>
        @else
          <span class="badge nav-badge">
            <i class="fas fa-dot-circle"></i>
          </span>
        @endif
      </p>
    </a>
  </li>





</ul>
