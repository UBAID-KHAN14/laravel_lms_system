@if (session('error'))
  <!-- Error Alert -->
  <div class="alert alert-danger alert-dismissible d-flex align-items-center fade show">
    <i class="bi-exclamation-triangle-fill"></i>
    <strong class="mx-2">Error!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif
