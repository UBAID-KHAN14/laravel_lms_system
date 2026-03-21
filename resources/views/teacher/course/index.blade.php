@extends('adminlte::page')

{{-- ================= STYLES ================= --}}
@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">

  <style>
    table.dataTable tbody tr:hover {
      background-color: #f4f6f9;
    }

    .badge-status {
      font-size: 12px;
      padding: 5px 8px;
    }
  </style>
@endsection

@section('title', 'My Courses')

@include('messages.toast')

@section('content_header')
  <h1>My Courses</h1>
@endsection

@section('content')

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Courses List</h3>
      <button id="bulkDeleteBtn" class="btn btn-sm btn-danger d-none">
        Delete Selected
      </button>

      <div class="ml-auto">
        <span class="badge badge-info">
          Total: {{ $courses->count() }}
        </span>
        <span class="badge badge-success">
          Published: {{ $courses->where('status', 'published')->count() }}
        </span>

        <a href="{{ route('teacher.courses.create') }}" class="btn btn-sm btn-primary ml-2">
          <i class="fas fa-plus"></i> New Course
        </a>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="courseTable">
        <thead class="thead-light">
          <tr>
            <th>
              <input type="checkbox" id="selectAll">
            </th>
            <th>#</th>
            <th>Course</th>
            <th>Category</th>
            <th>Level</th>
            <th>Price</th>
            <th>Status</th>
            <th width="150">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($courses as $course)
            <tr>
              <td>
                <input type="checkbox" class="row-checkbox" value="{{ $course->id }}">
              </td>
              <td>{{ $loop->iteration }}</td>

              {{-- COURSE --}}
              <td class="d-flex align-items-center">
                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="mr-2 rounded" width="50" height="40"
                  alt="thumbnail">
                <div>
                  <strong>{{ $course->title }}</strong><br>
                  <small class="text-muted">{{ $course->subCategory->name ?? '-' }}</small>
                </div>
              </td>

              {{-- CATEGORY --}}
              <td>{{ $course->category->name ?? '-' }}</td>

              {{-- LEVEL --}}
              <td>
                <span class="badge badge-secondary text-capitalize">
                  {{ $course->level }}
                </span>
              </td>

              <td>
                @if ($course->pricing)
                  {{ $course->pricing->currency_symbol ?? '₨' }} {{ number_format($course->pricing->price) }}
                @else
                  <span class="text-success">Free</span>
                @endif
              </td>


              {{-- STATUS --}}
              <td>
                @php
                  $statusColor = match ($course->status) {
                      'published' => 'success',
                      'rejected' => 'danger',
                      default => 'warning',
                  };
                @endphp
                <span class="badge badge-{{ $statusColor }} badge-status">
                  {{ ucfirst($course->status) }}
                </span>
              </td>

              {{-- ACTIONS --}}
              <td>

                <a href="{{ route('teacher.courses.manage', $course->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i>
                </a>




                <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST"
                  class="d-inline delete-form">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>

                @if ($course->status === 'draft' && $course->canBeSubmitted())
                  <a href="{{ route('teacher.course.submit', $course->id) }}" class="btn btn-sm btn-success"
                    title="Submit For Approval">
                    <i class="fas fa-edit"></i>
                  </a>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <form id="bulkDeleteForm" action="{{ route('teacher.courses.bulkDelete') }}" method="POST" class="d-none">

        @csrf
        @method('DELETE')

        <input type="hidden" name="ids" id="bulkIds">
      </form>

    </div>
  </div>

@endsection

{{-- ================= SCRIPTS ================= --}}
@section('js')
  <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @include('messages.message')

  <script>
    new DataTable('#courseTable', {
      pageLength: 10,
      ordering: true,
      responsive: true,
      language: {
        emptyTable: "No courses found"
      }
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
          title: 'Are you sure?',
          text: 'This course will be deleted!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });

    // START DELETE BULK
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const bulkBtn = document.getElementById('bulkDeleteBtn');

    // Select All
    selectAll.addEventListener('change', function() {
      checkboxes.forEach(cb => cb.checked = this.checked);
      toggleBulkButton();
    });

    // Single checkbox
    checkboxes.forEach(cb => {
      cb.addEventListener('change', toggleBulkButton);
    });

    function toggleBulkButton() {
      const checked = document.querySelectorAll('.row-checkbox:checked');

      bulkBtn.classList.toggle('d-none', checked.length === 0);
    }

    bulkBtn.addEventListener('click', function() {

      const ids = [...document.querySelectorAll('.row-checkbox:checked')]
        .map(cb => cb.value);

      if (ids.length === 0) return;

      Swal.fire({
        title: 'Delete selected courses?',
        text: `You are deleting ${ids.length} courses`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete'
      }).then((result) => {

        if (result.isConfirmed) {

          document.getElementById('bulkIds').value =
            JSON.stringify(ids);

          document.getElementById('bulkDeleteForm').submit();
        }
      });

    });
    // END DELETE BULK
  </script>
@endsection
