@extends('adminlte::page')
@section('title', 'User Management')
@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap4.min.css">
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

    /* Button Styling */
    .dt-buttons .btn {
      border-radius: 6px;
      margin-right: 4px;
    }
  </style>

@endsection

@include('messages.toast')

@section('content_header')
  <h1>User Management</h1>
@endsection

@section('content')
  <div class="card">
    {{-- ================= HEADER ================= --}}
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap">

      {{-- Title --}}
      <h3 class="card-title mb-0">
        <i class="fas fa-users mr-1"></i> Users List
      </h3>


      {{-- Right Side --}}
      <div class="d-flex align-items-center ml-auto flex-wrap gap-2">

        {{-- Stats --}}
        <span class="badge badge-info px-2 py-1">
          Total: {{ $users->count() }}
        </span>

        <span class="badge badge-success px-2 py-1">
          Active: {{ $users->where('is_active', true)->count() }}
        </span>

        {{-- Export Buttons --}}
        <div id="exportButtons" class="btn-group btn-group-sm ml-2"></div>
      </div>
    </div>

    {{-- ================= BODY ================= --}}
    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="userTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Email</th>
            <th>Role</th>
            <th class="text-center">Assign Role & Status</th>
            <th width="150">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($users as $user)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="d-flex align-items-center">

                @if ($user->image)
                  <img src="{{ asset('storage/' . $user->image) }}" width="40" height="40"
                    class="rounded-circle mr-2">
                @else
                  <div
                    class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mr-2 text-white"
                    style="width:40px;height:40px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                  </div>
                @endif
                {{ $user->name }}
              </td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->role ? ucfirst($user->role) : '-' }}</td>
              <td>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                  class="d-flex align-items-center">
                  @csrf
                  <select name="role" class="form-control form-control-sm mr-1">
                    <option value="">Role</option>
                    <option value="admin" @selected($user->role === 'admin')>
                      Admin
                    </option>
                    <option value="teacher" @selected($user->role === 'teacher')>
                      Teacher
                    </option>
                    <option value="student" @selected($user->role === 'student')>
                      Student
                    </option>
                  </select>

                  <select name="is_active" class="form-control form-control-sm mr-1">
                    <option value="1" @selected($user->is_active)>Active</option>
                    <option value="0" @selected(!$user->is_active)>Inactive</option>
                  </select>
                  <button type="submit" class="btn btn-sm btn-success">
                    <i class="fas fa-save"></i>
                  </button>
                </form>
              </td>

              {{-- ACTIONS --}}
              <td>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
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
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
  {{-- Buttons --}}
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
  {{-- Dependencies --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  {{-- SweetAlert --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @include('messages.message')
  <script>
    $(document).ready(function() {
      let table = new DataTable('#userTable', {
        pageLength: 10,
        ordering: true,
        language: {
          emptyTable: "No courses found"
        },
        responsive: true,


        // Layout
        dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",

        // Export Buttons
        buttons: [{
            extend: 'excelHtml5',
            className: 'btn btn-success btn-sm',
            text: '<i class="fas fa-file-excel"></i>',
            titleAttr: 'Export Excel'
          },

          {
            extend: 'pdfHtml5',
            className: 'btn btn-danger btn-sm',
            text: '<i class="fas fa-file-pdf"></i>',
            titleAttr: 'Export PDF',
            orientation: 'landscape',
            pageSize: 'A4'
          },

          {
            extend: 'csvHtml5',
            className: 'btn btn-info btn-sm',
            text: '<i class="fas fa-file-csv"></i>',
            titleAttr: 'Export CSV'
          },

          {
            extend: 'print',
            className: 'btn btn-secondary btn-sm',
            text: '<i class="fas fa-print"></i>',
            titleAttr: 'Print'
          }
        ]
      });

      // Move buttons to header
      table.buttons().container().appendTo('#exportButtons');

      // Delete confirmation
      document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be deleted!',
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
    });
  </script>
@endsection
