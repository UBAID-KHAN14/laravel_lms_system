@extends('adminlte::page')

@section('title', 'Edit Lecture Material')

@section('content_header')
  <h1>Edit Lecture Material</h1>
@endsection

@section('content')
  <form action="{{ route('teacher.course_lecture_materials.update', $lectureMaterial->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">

      <!-- LEFT -->
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-body">

            <!-- Lecture -->
            <div class="form-group">
              <label>Select Lecture</label>
              <select name="lecture_id" class="form-control">
                @foreach ($lectures as $lecture)
                  <option value="{{ $lecture->id }}"
                    {{ $lectureMaterial->lecture_id == $lecture->id ? 'selected' : '' }}>
                    {{ $lecture->section->course->title }}
                    → {{ $lecture->section->title }}
                    → {{ $lecture->title }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Replace File -->
            <div class="form-group">
              <label>Replace File (optional)</label>
              <input type="file" name="material_file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx">
              <small class="text-muted">
                Leave empty to keep existing file
              </small>
            </div>

            <!-- File Name -->
            <div class="form-group">
              <label>File Display Name</label>
              <input type="text" name="file_name" class="form-control" value="{{ $lectureMaterial->file_name }}">
            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-md-4">
        <div class="card card-secondary">
          <div class="card-body">
            <p class="text-muted"><strong>Current File:</strong></p>

            <p class="mb-1">
              <i class="fas fa-file"></i>
              {{ $lectureMaterial->file_name }}
            </p>

            <p class="text-muted small">
              Type: {{ $lectureMaterial->file_type }}
            </p>

            <a href="{{ asset('storage/' . $lectureMaterial->file_path) }}" target="_blank"
              class="btn btn-sm btn-outline-primary">
              <i class="fas fa-eye"></i> View File
            </a>
          </div>
        </div>
      </div>

    </div>

    <div class="mt-3 text-right">
      <button class="btn btn-primary">
        <i class="fas fa-save"></i> Update Material
      </button>
    </div>

  </form>
@endsection
