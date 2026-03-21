@extends('adminlte::page')

@section('title', 'All Student Enrollments')

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
  <h1>All Courses Enrollments</h1>
@endsection


@section('content')

  @include('messages.toast')

  <div class="card">

    <div class="card-header d-flex justify-content-between">

      <h3 class="card-title">Students List</h3>

      <span class="badge badge-info">
        Total: {{ $enrollments->count() }}
      </span>

    </div>


    <div class="card-body table-responsive">

      <table class="table-bordered table-hover table" id="enrollTable">

        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Course</th>
            <th>Student</th>
            <th>Teacher</th>
            <th>Student Email</th>
            <th>Activation</th>
            <th>Enrolled At</th>
          </tr>
        </thead>

        <tbody>

          @foreach ($enrollments as $enrollment)
            <tr>

              <td>{{ $loop->iteration }}</td>
              <td>
                {{ $enrollment->course->title ?? 'N/A' }}
              </td>
              <td>
                {{ $enrollment->user->name ?? 'N/A' }}
              </td>
              <td>
                {{ $enrollment->course->user->name ?? 'N/A' }}
              </td>
              <td>
                {{ $enrollment->user->email ?? 'N/A' }}
              </td>
              <td>
                <form action="{{ route('admin.courses.enroll_update', $enrollment->id) }}" method="POST">
                  @csrf

                  <select name="is_active" class="form-control form-control-sm d-inline w-auto">
                    <option value="1" @selected($enrollment->is_active === 1)>Active</option>
                    <option value="0" @selected($enrollment->is_active === 0)>Inactive</option>
                  </select>

                  <button class="btn btn-success btn-sm">
                    <i class="fas fa-save"></i>
                  </button>

                </form>
              </td>

              {{-- Date --}}
              <td>
                {{ $enrollment->created_at->format('d M Y') }}
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
    new DataTable('#enrollTable', {
      pageLength: 10,
      ordering: true,
      responsive: true,
      language: {
        emptyTable: "No enrollments found"
      }
    });
  </script>

@endsection
