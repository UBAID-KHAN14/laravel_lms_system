@if (session('alert_message'))
  <script>
    Swal.fire({
      icon: "{{ session('alert_type', 'error') }}",
      title: "{{ session('alert_title') }}",
      text: "{{ session('alert_message') }}",
      showConfirmButton: true
    });
  </script>
@endif
