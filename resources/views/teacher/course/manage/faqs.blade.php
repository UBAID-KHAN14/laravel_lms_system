@section('page-title')
  Manage FAQs
@endsection

@push('css')
  <style>
    .faq-item {
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 10px;
      background: #ffffff;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .faq-item:hover {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-color: #3b82f6;
    }

    .faq-item .question {
      font-weight: 600;
      font-size: 14px;
      color: #1f2937;
      margin-bottom: 4px;
    }

    .faq-item .preview {
      font-size: 12px;
      color: #6b7280;
      margin-bottom: 8px;
      line-height: 1.4;
      max-height: 40px;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }

    .faq-actions {
      display: flex;
      gap: 6px;
      justify-content: flex-end;
    }

    .faq-actions button {
      font-size: 12px;
      padding: 4px 8px;
    }

    .faq-card {
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 14px;
      background: #ffffff;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .faq-card label {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 4px;
      display: block;
    }

    .faq-card input,
    .faq-card textarea {
      font-size: 14px;
    }

    .top-actions {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .top-actions .btn {
      font-size: 14px;
      padding: 6px 14px;
    }

    .empty-state {
      text-align: center;
      padding: 40px 20px;
      color: #9ca3af;
    }

    .empty-state p {
      margin: 0;
      font-size: 14px;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    <!-- LEFT SIDE - FAQ LIST -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header" style="color: black;border-top: 3px solid blue;">
          <strong>Questions ({{ $faqs->count() }})</strong>
        </div>
        <div class="card-body" id="faqsList" style="max-height: 600px; overflow-y: auto;">
          @forelse($faqs as $faq)
            <div class="faq-item" data-id="{{ $faq->id }}" data-question="{{ e($faq->question) }}"
              data-answer="{{ e($faq->answer) }}">

              <div class="question">{{ $loop->iteration }}. {{ $faq->question }}</div>
              <div class="preview">{!! $faq->answer !!}</div>

              <div class="faq-actions">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editFAQ(this)">
                  <i class="fas fa-edit"></i>
                </button>

                <form action="{{ route('teacher.courses.faqs.delete', $faq->id) }}" method="POST"
                  class="delete-lecture-form d-inline">
                  @csrf
                  @method('DELETE')

                  <button type="button" class="btn btn-outline-danger btn-sm open-delete-modal" data-title="Delete FAQ"
                    data-message="Are you sure you want to delete this FAQ?" data-action="delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          @empty
            <div class="empty-state">
              <p>No FAQs yet. Add one from the form on the right.</p>
            </div>
          @endforelse

        </div>
      </div>
    </div>

    <!-- RIGHT SIDE - ADD/EDIT FAQ FORM -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header" style="color: black;border-top: 3px solid blue;">
          <strong id="formTitle"><i class="fas fa-plus"></i> Add New FAQ</strong>
        </div>
        <div class="card-body">
          <form id="faqForm" method="POST" action="{{ route('teacher.courses.faqs.store', $course->id) }}"
            data-update-url="{{ route('teacher.courses.faqs.update', [$course->id, ':id']) }}">
            @csrf

            <input type="hidden" id="faqId">

            <div class="form-group">
              <label>Question</label>
              <textarea id="question" name="question" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
              <label>Answer</label>
              <textarea id="answer" name="answer" class="form-control" rows="6" required></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100" id="submitBtn">Add FAQ</button>
            <button type="button" class="btn btn-secondary w-100 mt-2" id="cancelBtn" style="display:none"
              onclick="resetForm()">
              Cancel
            </button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function editFAQ(button) {
      const faq = button.closest('.faq-item');

      const id = faq.dataset.id;
      const question = faq.dataset.question;
      const answer = faq.dataset.answer;

      document.getElementById('faqId').value = id;
      document.getElementById('question').value = question;
      document.getElementById('answer').value = answer;

      document.getElementById('formTitle').innerHTML = '✏ Edit FAQ';
      document.getElementById('submitBtn').textContent = 'Update FAQ';
      document.getElementById('cancelBtn').style.display = 'block';

      const form = document.getElementById('faqForm');
      form.action = form.dataset.updateUrl.replace(':id', id);

      let method = form.querySelector('input[name="_method"]');
      if (!method) {
        method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'PUT';
        form.appendChild(method);
      }

      document.querySelector('.col-md-4').scrollIntoView({
        behavior: 'smooth'
      });
    }

    function resetForm() {
      const form = document.getElementById('faqForm');
      form.reset();

      document.getElementById('faqId').value = '';
      document.getElementById('formTitle').innerHTML = '➕ Add New FAQ';
      document.getElementById('submitBtn').textContent = 'Add FAQ';
      document.getElementById('cancelBtn').style.display = 'none';

      form.action = "{{ route('teacher.courses.faqs.store', $course->id) }}";

      const method = form.querySelector('input[name="_method"]');
      if (method) method.remove();
    }
  </script>
@endpush
