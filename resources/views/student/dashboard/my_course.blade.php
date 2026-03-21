@extends('adminlte::page')

@section('title', 'My Courses')

{{-- ================= STYLES ================= --}}
@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">

  <style>
    table.dataTable tbody tr:hover {
      background-color: #f4f6f9;
    }

    .dataTables_wrapper .dataTables_filter input {
      border-radius: 4px;
      border: 1px solid #ccc;
      padding: 5px 8px;
    }
  </style>
@endsection


@section('content_header')
  <h1>My Enrolled Courses</h1>
@endsection


@section('content')

  <div class="container py-4">

    <div class="row g-4">

      @foreach ($courses as $course)
        <div class="col-lg-3 col-md-4 col-sm-6">

          <div class="card h-100 border-0 shadow-sm">

            {{-- Thumbnail --}}
            <div style="height:180px; overflow:hidden">

              @if ($course->thumbnail)
                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-100 h-100 object-fit-cover"
                  alt="{{ $course->title }}">
              @else
                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                  No Image
                </div>
              @endif

            </div>


            <div class="card-body d-flex flex-column">

              {{-- Title --}}
              <h6 class="fw-bold text-truncate mb-1">
                {{ $course->title }}
              </h6>


              {{-- Instructor --}}
              <small class="text-muted mb-2">
                {{ $course->user->name ?? 'Instructor' }}
              </small>


              {{-- Rating --}}
              <div class="mb-2">

                <span class="text-warning">

                  @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= round($course->reviews_avg_rating ?? 0))
                      ★
                    @else
                      ☆
                    @endif
                  @endfor

                </span>

                <small class="text-muted">
                  ({{ $course->reviews_count ?? 0 }})
                </small>

              </div>


              {{-- Description --}}
              <p class="small text-muted mb-3" style="flex:1">
                {{ Str::limit(strip_tags($course->description), 70) }}
              </p>


              {{-- Button --}}
              <a href="{{ route('student.courses.learn', $course->id) }}"
                class="btn btn-outline-primary btn-sm w-100 mt-auto">

                View Course

              </a>

            </div>

          </div>

        </div>
      @endforeach

    </div>

  </div>


  <div class="card">

    <div class="card-header d-flex justify-content-between">
      <h3 class="card-title">My Courses</h3>

      <span class="badge badge-info">
        Total: {{ $courses->count() }}
      </span>
    </div>


    <div class="card-body table-responsive">

      <table class="table-bordered table-hover table" id="courseTable">

        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Course</th>
            <th>Teacher</th>
            <th>Enrolled At</th>
            <th width="150">Action</th>
          </tr>
        </thead>

        <tbody>

          @forelse ($courses as $course)
            <tr>

              <td>{{ $loop->iteration }}</td>

              {{-- Course Title --}}
              <td>
                <strong>{{ $course->title }}</strong>
              </td>

              {{-- Teacher --}}
              <td>
                {{ $course->user->name ?? 'N/A' }}
              </td>

              {{-- Enroll Date --}}
              <td>
                {{ $course->pivot->created_at->format('d M Y') }}
              </td>

              {{-- Action --}}
              <td>
                <a href="{{ route('student.courses.learn', $course->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-eye"></i> View
                </a>
              </td>

            </tr>

          @empty

            <tr>
              <td colspan="5" class="text-muted text-center">
                You have not enrolled in any course yet.
              </td>
            </tr>
          @endforelse

        </tbody>

      </table>

    </div>
  </div>

@endsection


{{-- ================= SCRIPTS ================= --}}
@section('js')

  <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>

  <script>
    new DataTable('#courseTable', {
      pageLength: 10,
      ordering: true,
      responsive: true
    });
  </script>

@endsection
