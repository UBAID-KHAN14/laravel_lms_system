@extends('adminlte::page')

@section('title', 'Student Enrollments')

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
  <h1>My Course Enrollments</h1>
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
            <th>Student</th>
            <th>Email</th>
            <th>Course</th>
            <th>Status</th>
            <th>Is Activation</th>
            <th>Enrolled At</th>
          </tr>
        </thead>

        <tbody>

          @foreach ($enrollments as $enroll)
            <tr>

              <td>{{ $loop->iteration }}</td>

              {{-- Student --}}
              <td>
                {{ $enroll->user->name ?? 'N/A' }}
              </td>

              {{-- Email --}}
              <td>
                {{ $enroll->user->email ?? 'N/A' }}
              </td>

              {{-- Course --}}
              <td>
                {{ $enroll->course->title ?? 'N/A' }}
              </td>

              <td>
                <form action="{{ route('teacher.enrollments.status_update', $enroll->id) }}" method="POST">
                  @csrf

                  <select name="status" class="form-control form-control-sm d-inline w-auto">
                    <option value="approved" @selected($enroll->status === 'approved')>Approved</option>
                    <option value="pending" @selected($enroll->status === 'pending')>Pending</option>
                  </select>


                  <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i></button>
                </form>
              </td>

              <td>
                <form action="{{ route('teacher.enrollments.activation_update', $enroll->id) }}" method="POST">
                  @csrf

                  <select name="is_active" class="form-control form-control-sm d-inline w-auto">
                    <option value="1" @selected($enroll->is_active === 1)>Active</option>
                    <option value="0" @selected($enroll->is_active === 0)>Inactive</option>
                  </select>


                  <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i></button>
                </form>
              </td>

              {{-- Date --}}
              <td>
                {{ $enroll->created_at->format('d M Y') }}
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
        emptyTable: "No courses found"
      }
    });
  </script>

@endsection
