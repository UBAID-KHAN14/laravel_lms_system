 @php
   // Calculate totals
   $totalLectures = $course->sections->sum(fn($section) => $section->lectures->count());
   $totalMaterials = $course->lectures->sum(fn($lecture) => $lecture->materials->count());
   $courseThumbnail = $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('images/default-course.png');
 @endphp
 @extends('home.layouts.app')
 @push('styles')
   <style>
     :root {
       --primary-color: #4361ee;
       --secondary-color: #3a0ca3;
       --light-bg: #f8f9fa;
       --dark-text: #2b2d42;
     }

     body {
       font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
       color: var(--dark-text);
     }

     /* Hero Section */
     .course-hero {
       background: linear-gradient(135deg, #0B8E96 0%, #0DA3AD 100%);
       /* background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); */
       color: white;
       padding: 3rem 0 2rem;
     }

     .course-header-badge {
       background: rgba(67, 97, 238, 0.2);
       color: #a5b4fc;
       padding: 0.5rem 1rem;
       border-radius: 20px;
       font-size: 0.9rem;
       border: 1px solid rgba(67, 97, 238, 0.3);
     }

     .course-actions-card {
       background: white;
       border-radius: 15px;
       padding: 1.5rem;
       box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
     }

     /* Tabs */
     .course-tabs .nav-link {
       color: #6c757d;
       font-weight: 600;
       padding: 1rem 1.5rem;
       border: none;
       border-bottom: 3px solid transparent;
     }

     .course-tabs .nav-link.active {
       color: var(--primary-color);
       border-bottom: 3px solid var(--primary-color);
     }

     /* Curriculum */
     .section-card {
       border: 1px solid #dee2e6;
       border-radius: 10px;
       margin-bottom: 1rem;
       overflow: hidden;
     }

     .section-header {
       background: #f8f9fa;
       padding: 1rem 1.25rem;
       cursor: pointer;
       border: none;
       width: 100%;
       text-align: left;
     }

     .lecture-item {
       padding: 1rem 1.5rem;
       border-bottom: 1px solid #eee;
     }

     .lecture-item:last-child {
       border-bottom: none;
     }

     .material-badge {
       font-size: 0.75rem;
       padding: 0.25rem 0.5rem;
     }

     /* Instructor Card */
     .instructor-card {
       background: white;
       border-radius: 10px;
       padding: 1.5rem;
       border: 1px solid #dee2e6;
     }

     /* Reviews */
     .review-card {
       background: white;
       border-radius: 8px;
       padding: 1.25rem;
       margin-bottom: 1rem;
       border: 1px solid #dee2e6;
     }

     .rating-stars {
       color: #ffc107;
     }

     /* Responsive */
     @media (max-width: 768px) {
       .course-hero {
         padding: 2rem 0 1rem;
       }
     }

     .button-color {
       border: 2px solid #0B8E96;
       background: none;
     }

     .button-color:hover {
       background-color: #0B8E96;
       color: white;
     }

     .progress-bar.bg-warning {
       background-color: #ffc107 !important;
     }
   </style>
 @endpush

 @section('content')


   {{-- HERO SECTION --}}
   <section class="course-hero">
     <div class="container">
       <div class="row">
         <div class="col-lg-8">
           <nav aria-label="breadcrumb" class="mb-3">
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-light">Home</a></li>
               <li class="breadcrumb-item"><a href="{{ route('courses.course_index') }}" class="text-light">Courses</a>
               </li>
               <li class="breadcrumb-item active text-light" aria-current="page">{{ $course->title }}</li>
             </ol>
           </nav>

           <div class="mb-3">
             <span class="course-header-badge me-2 text-white">
               <i class="bi bi-tag me-1"></i>
               {{ $course->category->name }}
               @if ($course->subCategory)
                 › {{ $course->subCategory->name }}
               @endif
             </span>

             @auth
               @if (!auth()->user()->canAccessCourse($course->id))
                 @if ($course->pricing && $course->pricing->price > 0)
                   <span class="course-header-badge bg-success text-white">
                     <i class="bi bi-gift me-1"></i>{{ $course->pricing->currency_symbol }}
                     {{ $course->pricing->price }}
                   </span>
                 @else
                   <span class="course-header-badge bg-success text-white">
                     <i class="bi bi-gift me-1"></i> FREE
                   </span>
                 @endif
               @endif
             @endauth

           </div>

           <h1 class="display-5 fw-bold mb-3">{{ $course->title }}</h1>
           <p class="lead mb-4">{{ Str::limit(strip_tags($course->description), 200) }}</p>

           <div class="d-flex align-items-center mb-4">
             <div class="d-flex align-items-center me-4">
               <img
                 src="{{ $course->user->image ? asset('storage/' . $course->user->image) : asset('images/default-avatar.png') }}"
                 alt="{{ $course->user->name }}" class="rounded-circle me-2"
                 style="width: 40px; height: 40px; object-fit: cover;">
               <div>
                 <div class="text-light fw-semibold">Instructor</div>
                 <div class="text-light">{{ $course->user->name }}</div>
               </div>
             </div>
           </div>

           <div class="row g-3">
             <div class="col-6 col-md-3">
               <div class="rounded bg-white p-3 text-center">
                 <div class="text-primary fw-bold mb-1">
                   <i class="bi bi-play-circle fs-4"></i>
                 </div>
                 <div class="fw-bold" style="color: #009dff">{{ $totalLectures }}</div>
                 <small class="text-muted">Lectures</small>
               </div>
             </div>
             <div class="col-6 col-md-3">
               <div class="rounded bg-white p-3 text-center">
                 <div class="text-primary fw-bold mb-1">
                   <i class="bi bi-folder fs-4"></i>
                 </div>
                 <div class="fw-bold" style="color: #009dff">{{ $course->sections->count() }}</div>
                 <small class="text-muted">Sections</small>
               </div>
             </div>
             <div class="col-6 col-md-3">
               <div class="rounded bg-white p-3 text-center">
                 <div class="text-primary fw-bold mb-1">
                   <i class="bi bi-file-text fs-4"></i>
                 </div>
                 <div class="fw-bold" style="color: #009dff">{{ $totalMaterials }}</div>
                 <small class="text-muted">Materials</small>
               </div>
             </div>
             <div class="col-6 col-md-3">
               <div class="rounded bg-white p-3 text-center">
                 <div class="text-primary fw-bold mb-1">
                   <i class="bi bi-question-circle fs-4"></i>
                 </div>
                 <div class="fw-bold" style="color: #009dff">{{ $course->faqs->count() }}</div>
                 <small class="text-muted">FAQs</small>
               </div>
             </div>
           </div>
         </div>

         <div class="col-lg-4 mt-lg-0 mt-4">
           <div class="course-actions-card">
             <div class="mb-4 text-center">
               <img src="{{ $courseThumbnail }}" alt="{{ $course->title }}" class="img-fluid mb-3 rounded"
                 style="max-height: 200px; object-fit: cover;">
             </div>

             <div class="mb-4 text-center">


               @auth
                 @if (!auth()->user()->canAccessCourse($course->id))
                   @if ($course->pricing && $course->pricing->price > 0)
                     <span class="display-4 fw-bold text-dark mb-0">
                       {{ $course->pricing->currency_symbol }}
                       {{ $course->pricing->price }}
                     </span>
                   @else
                     <span class="display-4 fw-bold text-success mb-0">Free</span>
                   @endif
                 @endif
               @endauth


             </div>

             <div class="d-grid gap-2">
               @auth

                 @if (auth()->user()->canAccessCourse($course->id))
                   <a href="{{ route('student.courses.learn', $course->id) }}" class="btn button-color btn-lg">

                     <i class="bi bi-play-circle me-2"></i>
                     Continue Learning

                   </a>
                 @elseif ($course->myEnrollment && $course->myEnrollment->status === 'pending')
                   <span class="btn btn-warning btn-lg disabled">
                     ⏳ Wait for Approval
                   </span>
                 @else
                   <form action="{{ route('student.course.enroll') }}" method="POST" style="display: contents;">
                     @csrf

                     <input type="hidden" name="course_id" value="{{ $course->id }}">

                     <button type="submit" class="btn button-color btn-lg">

                       <i class="bi bi-cart-plus me-2"></i>

                       {{ $course->pricing?->price == 0 ? 'Enroll Now' : 'Buy Course' }}

                     </button>

                   </form>
                 @endif
               @else
                 <a href="{{ route('login') }}" class="btn button-color btn-lg">
                   <i class="bi bi-lock me-2"></i>
                   Login to Enroll
                 </a>

               @endauth

             </div>

           </div>
         </div>
       </div>
     </div>
   </section>

   {{-- MAIN CONTENT --}}
   <div class="container my-5">
     <div class="row">
       <div class="col-lg-8">
         {{-- TABS NAVIGATION --}}
         <ul class="nav nav-tabs course-tabs mb-4" id="courseTab" role="tablist">
           <li class="nav-item" role="presentation">
             <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
               type="button">
               <i class="bi bi-info-circle me-2"></i>Overview
             </button>
           </li>
           <li class="nav-item" role="presentation">
             <button class="nav-link" id="curriculum-tab" data-bs-toggle="tab" data-bs-target="#curriculum"
               type="button">
               <i class="bi bi-list-check me-2"></i>Curriculum
             </button>
           </li>
           <li class="nav-item" role="presentation">
             <button class="nav-link" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor"
               type="button">
               <i class="bi bi-person me-2"></i>Instructor
             </button>
           </li>
           @if ($course->faqs->count() > 0)
             <li class="nav-item" role="presentation">
               <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" type="button">
                 <i class="bi bi-question-circle me-2"></i>FAQ ({{ $course->faqs->count() }})
               </button>
             </li>
           @endif

           {{-- Review --}}
           <li class="nav-item" role="presentation">
             <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button"
               role="tab">
               <i class="bi bi-star me-2"></i>
               Reviews ({{ $course->reviews->count() }})
             </button>
           </li>

           {{-- Comment --}}
           <li class="nav-item" role="presentation">
             <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment" type="button"
               role="tab">
               <i class="bi bi-chat-dots me-2"></i>
               Comments ({{ $course->comments->count() }})
             </button>
           </li>
         </ul>

         {{-- TAB CONTENT --}}
         <div class="tab-content" id="courseTabContent">
           {{-- OVERVIEW TAB --}}
           <div class="tab-pane fade show active" id="overview" role="tabpanel">
             <div class="card mb-4 border-0 shadow-sm">
               <div class="card-body">
                 <h4 class="card-title mb-4">Course Description</h4>
                 <div class="course-description">
                   {!! $course->description !!}
                 </div>
               </div>
             </div>
           </div>

           {{-- CURRICULUM TAB --}}
           <div class="tab-pane fade" id="curriculum" role="tabpanel">
             <div class="card border-0 shadow-sm">
               <div class="card-body">
                 <div class="d-flex justify-content-between align-items-center mb-4">
                   <h4 class="card-title mb-0">Course Curriculum</h4>
                   <div class="text-muted">
                     {{ $course->sections->count() }} sections • {{ $totalLectures }} lectures
                   </div>
                 </div>

                 @if ($course->sections->count() > 0)
                   @foreach ($course->sections as $section)
                     <div class="section-card mb-3">
                       <button class="section-header" type="button" data-bs-toggle="collapse"
                         data-bs-target="#section{{ $section->id }}">
                         <div class="d-flex justify-content-between align-items-center">
                           <div>
                             <strong>Section {{ $loop->iteration }}:</strong> {{ $section->title }}
                             <span class="badge bg-secondary ms-2">{{ $section->lectures->count() }} lectures</span>
                           </div>
                           <i class="bi bi-chevron-down"></i>
                         </div>
                       </button>

                       <div class="collapse" id="section{{ $section->id }}">
                         <div>
                           @foreach ($section->lectures as $lecture)
                             <div class="lecture-item">
                               <div class="d-flex justify-content-between align-items-start">
                                 <div>
                                   <h6 class="mb-1">
                                     <i class="bi bi-play-circle text-primary me-2"></i>
                                     {{ $lecture->title }}
                                   </h6>
                                   @if ($lecture->description)
                                     <p class="text-muted small mb-2">{!! Str::limit($lecture->description, 150) !!}</p>
                                   @endif

                                   {{-- Display Materials --}}
                                   @if ($lecture->materials->count() > 0)
                                     <div class="mt-2">
                                       <small class="text-muted d-block mb-1">Materials:</small>
                                       <div class="d-flex flex-wrap gap-1">
                                         @if (auth()->check() && auth()->user()->hasEnrolled($course->id))
                                           @foreach ($lecture->materials as $material)
                                             <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                               class="badge bg-light text-dark text-decoration-none border">
                                               <i class="bi bi-download me-1"></i>
                                               {{ Str::limit(basename($material->file_name), 20) }}
                                             </a>
                                           @endforeach
                                         @endif
                                       </div>
                                     </div>
                                   @endif
                                 </div>
                                 @if ((auth()->check() && auth()->user()->hasEnrolled($course->id)) || $lecture->is_preview)
                                   @if ($lecture->video_file || $lecture->video_url)
                                     <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary watch-btn"
                                       data-file="{{ $lecture->video_file ? asset('storage/' . $lecture->video_file) : '' }}"
                                       data-url="{{ $lecture->video_url ?? '' }}" data-bs-toggle="modal"
                                       data-bs-target="#videoModal">
                                       <i class="bi bi-play-fill"></i>
                                       {{ $lecture->video_file ? 'Watch Video' : 'Watch Online' }}
                                     </a>
                                   @endif
                                 @else
                                   <span class="text-muted">
                                     <i class="fas fa-lock"></i> {{ $lecture->title }}
                                   </span>
                                 @endif
                               </div>
                             </div>
                           @endforeach
                         </div>
                       </div>
                     </div>
                   @endforeach
                 @else
                   <div class="py-4 text-center">
                     <i class="bi bi-folder-x display-1 text-muted mb-3"></i>
                     <p class="text-muted">No curriculum available for this course yet.</p>
                   </div>
                 @endif
               </div>
             </div>
           </div>

           {{-- INSTRUCTOR TAB --}}
           <div class="tab-pane fade" id="instructor" role="tabpanel">
             <div class="instructor-card">
               <div class="row">
                 <div class="col-md-3 mb-md-0 mb-3 text-center">
                   <img
                     src="{{ $course->user->image ? asset('storage/' . $course->user->image) : asset('images/default-avatar.png') }}"
                     alt="{{ $course->user->name }}" class="rounded-circle mb-3"
                     style="width: 120px; height: 120px; object-fit: cover;">
                 </div>
                 <div class="col-md-9">
                   <h3>{{ $course->user->name }}</h3>
                   <p class="text-muted mb-4">
                     <i class="bi bi-award me-1"></i> Instructor
                   </p>

                   <div class="row mb-4">
                     <div class="col-6">
                       <div class="d-flex align-items-center">
                         <i class="bi bi-play-circle text-primary fs-4 me-2"></i>
                         <div>
                           <h5 class="mb-0">{{ $course->user->courses()->count() }}</h5>
                           <small class="text-muted">Courses</small>
                         </div>
                       </div>
                     </div>
                     <div class="col-6">
                       <div class="d-flex align-items-center">
                         <i class="bi bi-people text-primary fs-4 me-2"></i>
                         <div>
                           <h5 class="mb-0">
                             @php
                               $totalStudents = $course->user->courses->sum(function ($course) {
                                   return $course->enrollments()->count();
                               });
                             @endphp
                             {{ number_format($totalStudents) }}
                           </h5>
                           <small class="text-muted">Students</small>
                         </div>
                       </div>
                     </div>
                   </div>

                   @if ($course->user->bio)
                     <div class="mb-4">
                       <h5>About Instructor</h5>
                       <p>{{ $course->user->bio }}</p>
                     </div>
                   @endif

                   {{-- Display instructor's other courses --}}
                   @php
                     $otherCourses = $course->user
                         ->courses()
                         ->where('id', '!=', $course->id)
                         ->where('status', 'published')
                         ->limit(10)
                         ->get();
                   @endphp

                   @if ($otherCourses->count() > 0)
                     <div>
                       <h5 class="mb-3">Other Courses by {{ $course->user->name }}</h5>
                       <div class="row g-3">
                         @foreach ($otherCourses as $otherCourse)
                           <div class="col-12">
                             <div class="d-flex align-items-center rounded border p-3">
                               <img src="{{ asset('storage/' . $otherCourse->thumbnail) }}"
                                 alt="{{ $otherCourse->title }}" class="me-3 rounded"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                               <div class="flex-grow-1">
                                 <h6 class="mb-1">{{ Str::limit($otherCourse->title, 40) }}</h6>
                                 <div class="d-flex justify-content-between align-items-center">
                                   <small class="text-muted">{{ $otherCourse->category->name }}</small>
                                   @if ($otherCourse->pricing && $otherCourse->pricing->price > 0)
                                     <span class="fw-bold text-dark">
                                       {{ $otherCourse->pricing->currency_symbol }}
                                       {{ $otherCourse->pricing->price }}
                                     </span>
                                   @else
                                     <span class="badge bg-success">Free</span>
                                   @endif


                                 </div>
                               </div>
                               <a href="{{ route('courses.course_show', $otherCourse->slug) }}"
                                 class="btn btn-sm btn-outline-primary ms-3">
                                 View
                               </a>
                             </div>
                           </div>
                         @endforeach
                       </div>
                     </div>
                   @endif
                 </div>
               </div>
             </div>
           </div>

           {{-- FAQ TAB --}}
           @if ($course->faqs->count() > 0)
             <div class="tab-pane fade" id="faq" role="tabpanel">
               <div class="card border-0 shadow-sm">
                 <div class="card-body">
                   <h4 class="card-title mb-4">Frequently Asked Questions</h4>
                   <div class="accordion" id="faqAccordion">
                     @foreach ($course->faqs as $faq)
                       <div class="accordion-item mb-2">
                         <h2 class="accordion-header">
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                             data-bs-target="#faq{{ $faq->id }}">
                             {{ $faq->question }}
                           </button>
                         </h2>
                         <div id="faq{{ $faq->id }}" class="accordion-collapse collapse"
                           data-bs-parent="#faqAccordion">
                           <div class="accordion-body">
                             {{ $faq->answer }}
                           </div>
                         </div>
                       </div>
                     @endforeach
                   </div>
                 </div>
               </div>
             </div>
           @endif

           {{-- Review TAB --}}

           <div class="tab-pane fade" id="review" role="tabpanel">

             <div class="card">
               <div class="card-body">
                 <div class="row mb-4">
                   {{-- Left --}}
                   <div class="col-md-4 text-center">

                     <h1 class="fw-bold text-primary">
                       {{ number_format($course->averageRating(), 1) }}
                     </h1>

                     <div class="text-warning fs-4">

                       @for ($i = 1; $i <= 5; $i++)
                         @if ($i <= round($course->averageRating()))
                           ★
                         @else
                           ☆
                         @endif
                       @endfor

                     </div>

                     <p class="text-muted">
                       Based on {{ $course->reviews_count }} reviews
                     </p>

                   </div>
                   {{-- Right --}}
                   <div class="col-md-8">

                     @for ($i = 5; $i >= 1; $i--)
                       @php
                         $count = $ratings[$i] ?? 0;
                         $percent = $course->reviews_count ? ($count / $course->reviews_count) * 100 : 0;
                       @endphp

                       <div class="d-flex align-items-center mb-2">

                         <small class="me-2">{{ $i }} star</small>

                         <div class="progress flex-grow-1 me-2" style="height:8px">
                           <div class="progress-bar" style="width:{{ $percent }}%; background-color:#f4c150;">
                           </div>

                         </div>

                         <small>{{ $count }}</small>

                       </div>
                     @endfor

                   </div>
                 </div>
               </div>


               <div class="container" style="display: flex;justify-content: space-between;align-items: baseline;">
                 <p>What students are saying</p>
                 @if ($userReview)
                   <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                     data-bs-target="#editReviewModal">
                     Edit Your Review
                   </button>
                 @endif

               </div>

               @foreach ($course->reviews as $review)
                 <div class="m-3 mb-3 rounded border p-3">

                   <div class="d-flex justify-content-between">

                     <div>
                       <strong>{{ $review->user->name }}</strong>

                       <small class="text-muted ms-2">
                         {{ $review->created_at->diffForHumans() }}
                       </small>
                     </div>

                     <div class="text-warning">

                       @for ($i = 1; $i <= 5; $i++)
                         @if ($i <= $review->rating)
                           ★
                         @else
                           ☆
                         @endif
                       @endfor

                     </div>

                   </div>


                   <p class="mt-2">{{ $review->review }}</p>


                   @if (auth()->id() == $review->user_id)
                     <form action="{{ route('student.course.review.delete', $review->id) }}" method="POST"
                       class="text-end" onclick="return confirm('Are sure want to Delete the Rating.')">
                       @csrf
                       @method('DELETE')

                       <button class="btn btn-sm btn-outline-danger">
                         Delete
                       </button>

                     </form>
                   @endif

                 </div>
               @endforeach
             </div>



           </div>



           {{-- Comment TAB --}}
           <div class="tab-pane fade" id="comment" role="tabpanel">

             <div class="card">
               <div class="card-body">
                 {{-- Comment Form --}}
                 @if (auth()->check() && $course->is_enrolled)
                   <form action="{{ route('student.course.comment', $course->id) }}" method="POST">
                     @csrf

                     <div class="mb-2">
                       <textarea name="comment" class="form-control" placeholder="Write a comment..." required></textarea>
                     </div>

                     <input type="hidden" name="parent_id" value="">

                     <button class="btn btn-success btn-sm">
                       Post Comment
                     </button>
                   </form>
                 @endif


                 <hr>

                 {{-- Comments List --}}
                 @forelse($course->comments as $comment)
                   @include('home.courses.partials.course-comment', [
                       'comment' => $comment,
                   ])

                 @empty
                   <p>No comments yet.</p>
                 @endforelse


               </div>
             </div>

           </div>

         </div>



       </div>

       {{-- SIDEBAR --}}
       <div class="col-lg-4">
         {{-- Similar Courses by Category --}}
         @php
           $similarCourses = \App\Models\Teacher\Course\Course::where('category_id', $course->category_id)
               ->where('id', '!=', $course->id)
               ->where('status', 'published')
               ->limit(10)
               ->get();
         @endphp

         @if ($similarCourses->count() > 0)
           <div>
             <h5 class="mb-3">Similar Courses</h5>
             <div class="row g-3">
               @foreach ($similarCourses as $similar)
                 <div class="col-12">
                   <div class="d-flex align-items-center rounded border p-3">
                     <img src="{{ asset('storage/' . $similar->thumbnail) }}" alt="{{ $similar->title }}"
                       class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                     <div class="flex-grow-1">
                       <h6 class="mb-1">{{ Str::limit($similar->title, 40) }}</h6>
                       <div class="d-flex justify-content-between align-items-center">
                         <small class="text-muted">{{ $similar->category->name }}</small>
                         @if ($similar->pricing && $similar->pricing->price > 0)
                           <span class="fw-bold text-dark">
                             {{ $similar->pricing->currency_symbol }}
                             {{ $similar->pricing->price }}
                           </span>
                         @else
                           <span class="badge bg-success">Free</span>
                         @endif


                       </div>
                     </div>

                     <a href="{{ route('courses.course_show', $similar->slug) }}"
                       class="btn btn-sm btn-outline-primary ms-3">View</a>
                   </div>
                 </div>
               @endforeach
             </div>
           </div>
         @endif

         {{-- Course Features --}}
         <div class="card mb-4 mt-2 border-0 shadow-sm">
           <div class="card-body">
             <h5 class="card-title mb-4">
               <i class="bi bi-check-circle text-primary me-2"></i>
               What's Included
             </h5>
             <ul class="list-unstyled mb-0">
               <li class="mb-2">
                 <i class="bi bi-check text-success me-2"></i>
                 {{ $totalLectures }} on-demand lectures
               </li>
               <li class="mb-2">
                 <i class="bi bi-check text-success me-2"></i>
                 {{ $totalMaterials }} downloadable resources
               </li>
               <li class="mb-2">
                 <i class="bi bi-check text-success me-2"></i>
                 {{ $course->sections->count() }} course sections
               </li>
               <li class="mb-2">
                 <i class="bi bi-check text-success me-2"></i>
                 Access on mobile and desktop
               </li>
               @if ($course->faqs->count() > 0)
                 <li class="mb-2">
                   <i class="bi bi-check text-success me-2"></i>
                   {{ $course->faqs->count() }} FAQ support
                 </li>
               @endif


             </ul>
           </div>
         </div>

         {{-- Share Course --}}
         <div class="card border-0 shadow-sm">
           <div class="card-body">
             <h5 class="card-title mb-3">
               <i class="bi bi-share text-primary me-2"></i>
               Share this course
             </h5>
             <div class="d-flex gap-2">
               <button class="btn btn-outline-primary btn-sm flex-grow-1" onclick="shareOnFacebook()">
                 <i class="bi bi-facebook me-2"></i>Facebook
               </button>
               <button class="btn btn-outline-info btn-sm flex-grow-1" onclick="shareOnTwitter()">
                 <i class="bi bi-twitter me-2"></i>Twitter
               </button>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>


   @if ($userReview)
     <div class="modal fade" id="editReviewModal">

       <div class="modal-dialog">
         <div class="modal-content">



           <div class="modal-header">
             <h5>Edit Review</h5>
             <button class="btn-close" data-bs-dismiss="modal"></button>
           </div>

           <form action="{{ route('student.course.review.update', $userReview->id) }}" method="POST">
             @csrf
             @method('PUT')

             <div class="modal-body">

               <select name="rating" class="form-control mb-2">

                 @for ($i = 5; $i >= 1; $i--)
                   <option value="{{ $i }}" @selected($userReview->rating == $i)>
                     {{ $i }} Stars
                   </option>
                 @endfor

               </select>


               <textarea name="review" class="form-control" rows="4">{{ $userReview->review }}</textarea>

             </div>


             <div class="modal-footer">

               <button class="btn btn-primary">
                 Update
               </button>

             </div>

           </form>

         </div>
       </div>
     </div>
   @endif





   <!-- Video Modal -->
   <div class="modal fade" id="videoModal" tabindex="-1">
     <div class="modal-dialog modal-lg">
       <div class="modal-content">

         <div class="modal-header">
           <h5 class="modal-title">Lecture Video</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>

         <div class="modal-body text-center">

           <video id="modalVideo" width="500" height="300" controls style="max-width:100%; border-radius:8px;">
             <source src="" type="video/mp4">

             Your browser does not support the video tag.
           </video>

           {{-- YouTube Video --}}
           <iframe id="modalIframe" width="100%" height="280" style="max-width:500px; display:none;"
             frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
           </iframe>
         </div>

       </div>
     </div>
   </div>

   @push('js')
     <script>
       $(document).ready(function() {
         // Curriculum accordion
         $('.section-header').on('click', function() {
           const icon = $(this).find('i');
           if (icon.hasClass('bi-chevron-down')) {
             icon.removeClass('bi-chevron-down').addClass('bi-chevron-up');
           } else {
             icon.removeClass('bi-chevron-up').addClass('bi-chevron-down');
           }
         });

         // Smooth scroll for tabs
         // $('.course-tabs .nav-link').on('click', function(e) {
         //   e.preventDefault();
         //   const target = $(this).data('bs-target');
         //   $('html, body').animate({
         //     scrollTop: $(target).offset().top - 100
         //   }, 500);
         //   $(this).tab('show');
         // });
       });

       function shareOnFacebook() {
         const url = encodeURIComponent(window.location.href);
         const text = encodeURIComponent("Check out this course: {{ $course->title }}");
         window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`, '_blank');
       }

       function shareOnTwitter() {
         const url = encodeURIComponent(window.location.href);
         const text = encodeURIComponent("Check out this course: {{ $course->title }}");
         window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
       }

       function toggleReply(id) {
         let box = document.getElementById('reply-box-' + id);

         if (box) {
           box.classList.toggle('d-none');
         }
       }



       const modalVideo = document.getElementById('modalVideo');
       const modalIframe = document.getElementById('modalIframe');
       const videoModal = document.getElementById('videoModal');

       document.querySelectorAll('.watch-btn').forEach(button => {
         button.addEventListener('click', function() {

           let file = this.getAttribute('data-file');
           let url = this.getAttribute('data-url');

           // Reset both
           modalVideo.style.display = "none";
           modalIframe.style.display = "none";
           modalVideo.pause();
           modalVideo.src = "";
           modalIframe.src = "";

           // If local uploaded file exists
           if (file) {
             modalVideo.src = file;
             modalVideo.style.display = "block";
           }

           // If YouTube URL exists
           else if (url) {
             let embedUrl = convertToEmbed(url);
             modalIframe.src = embedUrl;
             modalIframe.style.display = "block";
           }

         });
       });

       // Stop video when modal closes
       videoModal.addEventListener('hidden.bs.modal', function() {
         modalVideo.pause();
         modalVideo.src = "";
         modalIframe.src = "";
       });

       // Convert YouTube link to embed
       function convertToEmbed(url) {
         let videoId = '';

         if (url.includes("watch?v=")) {
           videoId = url.split("watch?v=")[1].split("&")[0];
         } else if (url.includes("youtu.be/")) {
           videoId = url.split("youtu.be/")[1];
         }

         return "https://www.youtube.com/embed/" + videoId + "?autoplay=1";
       }
     </script>
   @endpush
 @endsection
