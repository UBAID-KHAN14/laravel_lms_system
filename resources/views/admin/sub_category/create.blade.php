@extends('adminlte::page')

@section('title', 'Create Sub Category')

@section('content_header')
  <h1 class="text-dark m-0">Create Sub Category</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-folder-plus mr-1"></i>
            Add Sub Category
          </h3>
          <div style="display: flex;justify-content: end;">
            <a href="{{ route('admin.sub_categories.index') }}" class="btn btn-outline-primary">
              <i class="fas fa-arrow-left mr-1"></i> Back to Sub Categories</a>
          </div>

          <form action="{{ route('admin.sub_categories.store') }}" method="POST">
            @csrf

            <div class="card-body">

              <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                  <option value="">-- Select Category --</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="name">Sub Category Name</label>
                <input type="text" name="name" id="name" class="form-control"
                  placeholder="Enter sub category name">
              </div>

            </div>

            <div class="card-footer text-right">
              <button type="reset" class="btn btn-outline-secondary"><i class="fas fa-undo mr-1"></i> Reset</button>
              <button type="submit" class="btn btn-dark">
                <i class="fas fa-save mr-1"></i> Save
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  @endsection
