<h5 class="mb-3">Course Builder</h5>

<ul class="nav nav-pills flex-column">

  @php
    $tabs = [
        'basic' => 'Basic Info',
        'curriculum' => 'Curriculum',
        'materials' => 'Lecture Materials',
        'faqs' => 'FAQs',
        'pricing' => 'Pricing',
        'publish' => 'Publish',
    ];
  @endphp

  @foreach ($tabs as $key => $label)
    <li class="nav-item mb-1">
      <a href="{{ route('teacher.courses.manage', $course->id) }}?tab={{ $key }}"
        class="nav-link {{ $tab === $key ? 'active' : '' }}">
        {{ $label }}
      </a>
    </li>
  @endforeach

</ul>
