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

@section('title', 'Lectures Materials')

@include('messages.toast')

@section('content_header')
  <h1>My Course FAQs</h1>
@endsection

@section('content')

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Course FAQs List</h3>

      <div class="ml-auto">
        <span class="badge badge-info">

        </span>

        <a href="{{ route('teacher.course_faqs.create') }}" class="btn btn-sm btn-primary ml-2">
          <i class="fas fa-plus"></i> New FAQ
        </a>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table-bordered table-hover table" id="courseTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Course Id</th>
            <th>Question</th>
            <th>Answer</th>
            <th width="150">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($faqs as $faq)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $faq->course->title }}</td>
              <td>{{ Str::limit($faq->question, 50) }}</td>
              <td>{{ Str::limit($faq->answer, 50) }}</td>
              <td>
                <a href="{{ route('teacher.course_faqs.edit', $faq->id) }}" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('teacher.course_faqs.destroy', $faq->id) }}" method="POST"
                  class="d-inline delete-form">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i> Delete
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
