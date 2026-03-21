@section('page-title')
  Manage Curriculum
@endsection

@push('css')
  <style>
    .section-card {
      border: 1px solid #dee2e6;
      border-radius: 6px;
      margin-bottom: 20px;
      background: #fff;
    }

    .section-header {
      padding: 15px;
      background: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .lecture-card {
      border: 1px dashed #ccc;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 15px;
      background: #fafafa;
    }
  </style>
@endpush

@section('content')
  <div class="card">
    <div class="card-body">

      {{-- ✅ EVERYTHING INSIDE FORM --}}
      <form method="POST" action="{{ route('teacher.courses.curriculum.save', $course->id) }}"
        enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
          <button type="button" class="btn btn-primary" onclick="addSection()">
            <i class="fas fa-plus"></i> Add Section
          </button>

          <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Save Curriculum
          </button>
        </div>

        <div id="sectionsContainer">

          {{-- ================= EXISTING SECTIONS ================= --}}
          @foreach ($sections as $sIndex => $section)
            <div class="section-card">

              <div class="section-header">
                <input type="hidden" name="sections[{{ $sIndex }}][id]" value="{{ $section->id }}">

                <input type="text" name="sections[{{ $sIndex }}][title]" value="{{ $section->title }}"
                  class="form-control w-75" placeholder="Section title">


                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.section-card').remove()">
                  <i class="fas fa-trash"></i>
                </button>
              </div>

              <div class="card-body">
                <div class="lectures">

                  {{-- ================= EXISTING LECTURES ================= --}}
                  @foreach ($section->lectures as $lIndex => $lecture)
                    <div class="lecture-card">

                      <input type="hidden" name="sections[{{ $sIndex }}][lectures][{{ $lIndex }}][id]"
                        value="{{ $lecture->id }}">

                      <input type="text" name="sections[{{ $sIndex }}][lectures][{{ $lIndex }}][title]"
                        value="{{ $lecture->title }}" class="form-control mb-2" placeholder="Lecture title">

                      <textarea name="sections[{{ $sIndex }}][lectures][{{ $lIndex }}][description]" class="form-control mb-2"
                        placeholder="Description">{{ $lecture->description }}</textarea>

                      <input type="text"
                        name="sections[{{ $sIndex }}][lectures][{{ $lIndex }}][video_url]"
                        value="{{ $lecture->video_url }}" class="form-control mb-2" placeholder="Video URL">

                      <input type="file"
                        name="sections[{{ $sIndex }}][lectures][{{ $lIndex }}][video_file]"
                        class="form-control mb-2">


                      <div class="form-check mb-2">

                        {{-- Hidden input (IMPORTANT) --}}
                        <input type="hidden"
                          name="sections[{{ $sIndex }}][lectures][{{ $lIndex }}][is_preview]"
                          value="0">

                        <input type="checkbox"
                          name="sections[{{ $sIndex }}][lectures][{{ $lIndex }}][is_preview]" value="1"
                          class="form-check-input" id="previewCheck{{ $sIndex }}{{ $lIndex }}"
                          {{ $lecture->is_preview ? 'checked' : '' }}>

                        <label class="form-check-label" for="previewCheck{{ $sIndex }}{{ $lIndex }}">
                          Mark as Preview
                        </label>
                      </div>


                      <button type="button" class="btn btn-danger btn-sm"
                        onclick="this.closest('.lecture-card').remove()">
                        <i class="fas fa-trash-alt"></i> Remove Lecture
                      </button>

                    </div>
                  @endforeach

                </div>

                <button type="button" class="btn btn-success btn-sm mt-2" onclick="addLecture(this)">
                  <i class="fas fa-plus"></i> Add Lecture
                </button>
              </div>

            </div>
          @endforeach

        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function addSection() {
      let sectionIndex = document.querySelectorAll('.section-card').length;

      document.getElementById('sectionsContainer').insertAdjacentHTML('beforeend', `
    <div class="section-card">

      <div class="section-header">
        <input type="text"
               name="sections[${sectionIndex}][title]"
               class="form-control w-75"
               placeholder="Section title">

        <button type="button"
                class="btn btn-danger btn-sm"
                onclick="this.closest('.section-card').remove()">
          <i class="fas fa-trash"></i>
        </button>
      </div>

      <div class="card-body">
        <div class="lectures"></div>

        <button type="button"
                class="btn btn-success btn-sm mt-2"
                onclick="addLecture(this)">
          <i class="fas fa-plus"></i> Add Lecture
        </button>
      </div>

    </div>
  `);
    }

    function addLecture(btn) {
      let section = btn.closest('.section-card');
      let sectionIndex = Array.from(document.querySelectorAll('.section-card')).indexOf(section);
      let lectures = section.querySelector('.lectures');
      let lectureIndex = lectures.children.length;

      lectures.insertAdjacentHTML('beforeend', `
    <div class="lecture-card">

      <input type="text"
             name="sections[${sectionIndex}][lectures][${lectureIndex}][title]"
             class="form-control mb-2"
             placeholder="Lecture title">

      <textarea name="sections[${sectionIndex}][lectures][${lectureIndex}][description]"
                class="form-control mb-2"
                placeholder="Description"></textarea>

      <input type="text"
             name="sections[${sectionIndex}][lectures][${lectureIndex}][video_url]"
             class="form-control mb-2"
             placeholder="Video URL">

      <input type="file"
             name="sections[${sectionIndex}][lectures][${lectureIndex}][video_file]"
             class="form-control mb-2">

     <div class="form-check mb-2">

      <input type="hidden"
            name="sections[${sectionIndex}][lectures][${lectureIndex}][is_preview]"
            value="0">

      <input type="checkbox"
            name="sections[${sectionIndex}][lectures][${lectureIndex}][is_preview]"
            value="1"
            class="form-check-input"
            id="previewCheck${sectionIndex}${lectureIndex}">

      <label class="form-check-label"
            for="previewCheck${sectionIndex}${lectureIndex}">
        Mark as Preview
      </label>

    </div>


      <button type="button"
              class="btn btn-danger btn-sm"
              onclick="this.closest('.lecture-card').remove()">
        <i class="fas fa-trash-alt"></i> Remove Lecture
      </button>

    </div>
  `);
    }
  </script>
@endpush
