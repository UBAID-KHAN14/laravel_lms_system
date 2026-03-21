<div class="card">

  <div class="card" style="margin: 35px; border-top:3px solid blue">
    @foreach ($sections as $section)
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-folder"></i> Section {{ $loop->iteration }}: {{ $section->title }}
        </div>

        <div class="card" style="margin: 15px">
          @foreach ($section->lectures as $lecture)
            <div class="card-body border-top">

              <i class="fas fa-video"></i> <strong>Lecture {{ $loop->iteration }}: {{ $lecture->title }}</strong>

              @if ($lecture->materials->count())
                <div class="table-responsive mb-3 mt-3">
                  <table class="table-sm table-hover table">
                    <thead class="table-light">
                      <tr>
                        <th>File Name</th>
                        <th>Type</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($lecture->materials as $material)
                        <tr>
                          <td>
                            <i class="fas fa-file"></i> {{ $material->file_name }}
                          </td>
                          <td>
                            <span
                              class="badge bg-info">{{ strtoupper(pathinfo($material->file_name, PATHINFO_EXTENSION)) }}</span>
                          </td>
                          <td>
                            <a href="{{ asset('storage/' . $material->file_path) }}" class="btn btn-sm btn-info"
                              title="View/Download" download>
                              <i class="fas fa-download"></i>
                            </a>
                            <form action="{{ route('teacher.materials.destroy', $material->id) }}" method="POST"
                              style="display: inline;" class="delete-lecture-form">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-danger btn-sm open-delete-modal"
                                data-title="Delete Materials"
                                data-message="Are you sure you want to delete this Materials?">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <p class="text-muted mt-2">
                  No materials uploaded for this lecture yet.
                </p>
              @endif

              <form action="{{ route('teacher.lectures.materials.store', $lecture->id) }}" method="POST"
                enctype="multipart/form-data" class="mt-3">
                @csrf

                <label class="fw-bold">Upload New Materials</label>

                <input type="file" name="materials[]" multiple class="form-control mt-2"
                  accept=".pdf,.ppt,.pptx,.doc,.docx,.xls,.xlsx,.zip,.txt">

                <small class="text-muted">
                  Maximum file size: 50MB. Supported: PDF, PPT, Word, Excel, ZIP, TXT
                </small>

                <button class="btn btn-primary btn-sm mt-2">
                  Upload Materials
                </button>
              </form>

            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
</div>
