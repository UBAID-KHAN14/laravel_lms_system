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
  <h1>User Management</h1>


@endsection

@section('content')


  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h3 class="card-title">Term And Privacy List</h3>
      <div class="ml-auto">
        <span class="badge badge-info">
          Total Term And Privacy: {{ $termAndPrivacies->count() }}
        </span>
        <span class="badge badge-success">
          Active Term And Privacy: {{ $termAndPrivacies->where('status', true)->count() }}
        </span>
        <span>
          <a href="{{ route('admin.term_privacy.create') }}" class="btn btn-sm btn-success ml-2">
            <i class="fas fa-plus"></i> Add Term And Privacy</a>
        </span>
      </div>

    </div>

    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="userTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Type</th>
            <th>Heading</th>
            <th>Body</th>
            <th>Status</th>
            <th>Sort Order</th>
            <th width="160">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($termAndPrivacies as $termPrivacy)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $termPrivacy->type }}</td>
              <td>{{ $termPrivacy->heading }}</td>
              <td>{!! Str::limit(strip_tags($termPrivacy->body), 30) !!}</td>
              <td>
                @if ($termPrivacy->status == 1)
                  <span class="badge badge-success">Active</span>
                @else
                  <span class="badge badge-danger">Inactive</span>
                @endif
              </td>
              <td>{{ $termPrivacy->sort_order }}</td>



              {{-- ACTIONS --}}
              <td>
                <a href="{{ route('admin.term_privacy.edit', $termPrivacy->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('admin.term_privacy.destroy', $termPrivacy->id) }}" method="POST"
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
        emptyTable: "No Terms and Privacy found"
      },
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
