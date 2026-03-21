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
  <h1>My Lectures</h1>
@endsection

@section('content')

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Courses Lectures List</h3>

      <div class="ml-auto">
        <span class="badge badge-info">
          Total: {{ $courseLectures->count() }}
        </span>

        <a href="{{ route('teacher.course_lectures.create') }}" class="btn btn-sm btn-primary ml-2">
          <i class="fas fa-plus"></i> New Lecture
        </a>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="courseTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Section Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Video or Url</th>
            <th width="150">Actions</th>
          </tr>
        </thead>

        <tbody>

          @forelse ($courseLectures as $lecture)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $lecture->section->title }}</td>
              <td>{{ $lecture->title }}</td>
              <td>{{ Str::limit($lecture->description, 50) }}</td>
              <td>
                @if ($lecture->video_url || $lecture->video_file)
                  @if ($lecture->video_url)
                    <a href="{{ $lecture->video_url }}" target="_blank">Video URL</a>
                  @endif

                  @if ($lecture->video_file)
                    <span>Video File Uploaded</span>
                  @endif
                @endif
              </td>
              <td>
                <a href="{{ route('teacher.course_lectures.edit', $lecture->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('teacher.course_lectures.destroy', $lecture->id) }}" method="POST"
                  class="d-inline delete-form">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
          @endforelse

        </tbody>
      </table>
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
      responsive: true
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
  </script>
@endsection
