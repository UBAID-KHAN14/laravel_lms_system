@extends('adminlte::page')
{{-- ================= STYLES ================= --}}
@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">

  <style>
    table.dataTable tbody tr:hover {
      background-color: #f4f6f9;
    }

    .form-control-sm {
      min-width: 110px;
    }

    .dataTables_wrapper .dataTables_filter input {
      border-radius: 4px;
      border: 1px solid #ccc;
      padding: 5px 8px;
    }
  </style>
@endsection
@section('title', 'Course Approvals')
@include('messages.toast')
@section('content_header')
  <h1>Course Approvals</h1>
@endsection
@section('content')

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Courses Pending Approval</h3>
      <div class="ml-auto"></div>
      <span class="badge badge-info">
        Total: {{ $courses->count() }}
      </span>
      <span class="badge badge-success mx-2">
        Approved: {{ $courses->where('status', 'published')->count() }}
      </span>
    </div>
  </div>
  <div class="card-body table-responsive">
    <table class="table-bordered table-hover table" id="courseTable">
      <thead class="thead-light">
        <tr>
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
            <td>{{ $loop->iteration }}</td>
            <td>{{ $course->title }}</td>
            <td>{{ $course->category->name }}</td>
            <td>{{ ucfirst($course->level) }}</td>
            <td>
              @if ($course->price)
                ${{ number_format($course->price, 2) }}
              @else
                Free
              @endif
            </td>
            <td>
              <span
                class="badge badge-status @if ($course->status == 'pending') badge-warning 
                                    @elseif ($course->status == 'published') badge-success 
                                    @elseif ($course->status == 'rejected') badge-danger 
                                    @else badge-secondary @endif">
                {{ ucfirst($course->status) }}
              </span>
            </td>
            <td>
              {{-- @if ($course->status === 'published')
                <span class="text-success">
                  <i class="fas fa-check-circle mr-1"></i>
                  Already Approved
                </span>
              @elseif ($course->status === 'rejected')
                <span class="text-danger">
                  <i class="fas fa-times-circle mr-1"></i>
                  Already Rejected
                </span>
              @else --}}
              <a href="{{ route('admin.courses_overview.index', $course->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye mr-1"></i> Overview
              </a>
              {{-- @endif --}}
            </td>

          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  </div>
@endsection

{{-- ================= SCRIPTS ================= --}}
@section('js')
  <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#courseTable').DataTable({
        "order": [
          [0, "asc"]
        ],
        "columnDefs": [{
          "orderable": false,
          "targets": [6]
        }]
      });
    });
  </script>
@endsection
