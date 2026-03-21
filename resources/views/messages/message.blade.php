{{-- @if (session('success'))
  <!-- Success Alert -->
  <div class="alert alert-success alert-dismissible d-flex align-items-center fade show">
    <i class="bi-check-circle-fill"></i>
    <strong class="mx-2">Success!</strong> {{ session('success') }}.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif --}}

{{-- ✅ Success alert ONLY when delete happened --}}
@if (session('alert_message'))
  <script>
    Swal.fire({
      icon: "{{ session('alert_type', 'success') }}",
      title: "{{ session('alert_title') }}",
      text: "{{ session('alert_message') }}",
      showConfirmButton: true,

    });
  </script>
@endif
