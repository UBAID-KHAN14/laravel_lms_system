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

@section('title', 'User Management')

@include('messages.toast')

@section('content_header')
  <h1>Category Management</h1>
@endsection

@section('content')


  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h3 class="card-title">Category List</h3>
      <div class="ml-auto">
        <span class="badge badge-info">
          Total Categories: {{ $categories->count() }}
        </span>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success ml-2">
          <i class="fas fa-plus"></i> Add Category</a>
      </div>

    </div>

    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="userTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th width="160">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($categories as $category)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $category->name }}</td>
              {{-- ACTIONS --}}
              <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                  class="d-inline delete-form">
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
  <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @include('messages.message')
  <script>
    new DataTable('#userTable', {
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
  </script>
@endsection
