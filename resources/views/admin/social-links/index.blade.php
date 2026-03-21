@extends('adminlte::page')

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

@section('title', 'Social Links')

@include('messages.toast')

@section('content_header')
  <h1>Social Links</h1>
@endsection

@section('content')

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Social Links List</h3>

      <div class="d-flex align-items-center ml-auto gap-2">
        <span class="badge badge-info">
          Total Links: {{ $socialLinks->count() }}
        </span>

        <a href="{{ route('admin.socialLinks.create') }}" class="btn btn-sm btn-success ml-2">
          <i class="fas fa-plus"></i> Add Social Link
        </a>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="socialTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>URL</th>
            <th>Icon Class</th>
            <th>Status</th>
            <th width="130">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($socialLinks as $socialLink)
            <tr>
              <td>{{ $loop->iteration }}</td>

              <td> <i class="{{ $socialLink->icon_class }}" style="font-size:20px;color:#1877f2;"></i>
                {{ $socialLink->name ?? 'N/A' }}</td>

              <td>
                <a href="{{ $socialLink->url }}" target="_blank">
                  {{ Str::limit($socialLink->url, 30) }}
                </a>
              </td>

              <td>
                <code>{{ $socialLink->icon_class }}</code>
              </td>

              <td>
                @if ($socialLink->status == 1)
                  <span class="badge badge-success">Active</span>
                @else
                  <span class="badge badge-danger">Inactive</span>
                @endif
              </td>

              <td>
                <a href="{{ route('admin.socialLinks.edit', $socialLink->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('admin.socialLinks.destroy', $socialLink->id) }}" method="POST"
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
    new DataTable('#socialTable', {
      pageLength: 10,
      ordering: true,
      responsive: true,
      language: {
        emptyTable: "No social links found"
      },
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
          title: 'Are you sure?',
          text: 'This social link will be permanently deleted!',
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
