@extends('adminlte::page')

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

@section('title', 'Sub Category Management')

@include('messages.toast')

@section('content_header')
  <h1>Sub Category Management</h1>
@endsection

@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Sub Category List</h3>
      <div class="ml-auto">
        <span class="badge badge-info">
          Total Sub Categories: {{ $sub_categories->count() }}
        </span>
        <a href="{{ route('admin.sub_categories.create') }}" class="btn btn-sm btn-success ml-2">
          <i class="fas fa-plus"></i> Add Sub Category</a>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="subCategoryTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Category</th>
            <th>Sub Category Name</th>
            <th width="160">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sub_categories as $sub_category)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $sub_category->category->name ?? '-' }}</td>
              <td>{{ $sub_category->name }}</td>
              <td>
                <a href="{{ route('admin.sub_categories.edit', $sub_category->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('admin.sub_categories.destroy', $sub_category->id) }}" method="POST"
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

@section('js')
  <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @include('messages.message')

  <script>
    // Initialize DataTable
    new DataTable('#subCategoryTable', {
      pageLength: 10,
      ordering: true,
      responsive: true,
      language: {
        emptyTable: "No Sub Categories Found"
      },
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Are you sure?',
          text: 'This sub-category will be deleted!',
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
