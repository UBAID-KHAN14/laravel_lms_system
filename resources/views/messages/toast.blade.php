@if (session('success') || session('error'))
  @push('js')
    <script>
      document.addEventListener('DOMContentLoaded', function() {

        toastr.options = {
          closeButton: true,
          progressBar: true,
          timeOut: 3000,
          extendedTimeOut: 1000,
          positionClass: "toast-top-right",
        };

        @if (session('success'))
          toastr.success(@json(session('success')));
        @endif

        @if (session('error'))
          toastr.error(@json(session('error')));
        @endif

      });
    </script>
  @endpush
@endif
