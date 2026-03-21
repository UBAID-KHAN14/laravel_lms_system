<div class="container mt-4">
  <div class="card border-0 shadow-sm">
    <div class="card-header border-bottom bg-white">
      <h6 class="fw-semibold mb-0">
        <i class="bi bi-tag"></i> Course Pricing
      </h6>
    </div>

    <div class="card-body">
      <form action="{{ route('teacher.courses.price.store') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->id }}">

        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label fw-semibold">Currency</label>
            <select class="form-control form-select" name="currency" id="currency">
              @foreach ($currencies as $currency)
                <option value="{{ $currency->code }}" data-symbol="{{ $currency->symbol }}">
                  {{ $currency->code }} - {{ $currency->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Currency Symbol</label>
            <input type="text" class="form-control bg-light" name="currency_symbol" id="currencySymbol" readonly>
          </div>


          <div class="col-md-12">
            <label class="form-label fw-semibold">Course Price</label>
            <input type="number" class="form-control" name="price" placeholder="100" min="0"
              value="{{ $course->pricing->price ?? '' }}">
            <small class="text-muted">Enter the price students will pay to enroll in your course</small>
          </div>

          <div class="col-md-12 d-flex justify-content-between mt-3">
            {{-- <a href="{{ route('teacher.courses.faqs') }}" class="btn btn-outline-secondary">← Back to FAQs</a> --}}
            <button class="btn btn-primary px-4">Save & Continue →</button>
          </div>

        </div>
      </form>

      @if ($course->pricing)
        <hr>
        <h6>Current Pricing</h6>
        <table class="table-bordered mt-2 table">
          <thead>
            <tr>
              <th>Price</th>
              <th>Currency</th>
              <th>Symbol</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $course->pricing->price }}</td>
              <td>{{ $course->pricing->currency }}</td>
              <td>{{ $course->pricing->currency_symbol }}</td>
              <td>
                <form action="{{ route('teacher.courses.price.destroy', $course->pricing) }}" method="POST"
                  onsubmit="return confirm('Are you sure?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      @endif
    </div>
  </div>
</div>

@push('scripts')
  <script>
    document.getElementById('currency').addEventListener('change', function() {
      let selectedOption = this.options[this.selectedIndex];
      let symbol = selectedOption.getAttribute('data-symbol');
      document.getElementById('currencySymbol').value = symbol;
    });

    // Set default symbol on page load
    window.onload = function() {
      document.getElementById('currency').dispatchEvent(new Event('change'));
    };
  </script>
@endpush
