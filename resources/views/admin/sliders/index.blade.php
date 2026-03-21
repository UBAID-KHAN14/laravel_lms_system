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

@section('title', 'Slider Management')

@include('messages.toast')

@section('content_header')
  <h1>Slider Management</h1>
@endsection

@section('content')

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Slider List</h3>

      <div class="d-flex align-items-center ml-auto gap-2">
        <span class="badge badge-info">
          Total Sliders: {{ $sliders->count() }}
        </span>

        <a href="{{ route('admin.sliders.create') }}" class="btn btn-sm btn-success ml-2">
          <i class="fas fa-plus"></i> Add New Slider
        </a>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="sliderTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th width="130">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($sliders as $slider)
            <tr>
              <td>{{ $loop->iteration }}</td>

              <td>
                @if ($slider->image)
                  <img src="{{ asset('storage/' . $slider->image) }}"
                    style="width:80px;height:45px;object-fit:cover;border-radius:4px;">
                @else
                  <span class="text-muted">No Image</span>
                @endif
              </td>

              <td>{{ $slider->title }}</td>

              <td>{!! Str::limit($slider->description, 60) !!}</td>

              <td>
                @if ($slider->status == 0)
                  <span class="badge badge-success">Visible</span>
                @else
                  <span class="badge badge-danger">Hidden</span>
                @endif
              </td>

              <td>
                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST"
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
    new DataTable('#sliderTable', {
      pageLength: 10,
      ordering: true,
      responsive: true,
      language: {
        emptyTable: "No Sliders found"
      },
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
          title: 'Are you sure?',
          text: 'This slider will be permanently deleted!',
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
