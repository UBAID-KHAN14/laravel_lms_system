@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
  <h1 class="text-dark m-0">Edit Category</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card card-warning card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-edit mr-1"></i>
            Edit Category
          </h3>
          <div style="display: flex;justify-content: end;">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
              <i class="fas fa-arrow-left mr-1"></i> Back to Categories</a>
          </div>

          <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

              <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                  class="form-control" placeholder="Enter category name">
              </div>

            </div>

            <div class="card-footer text-right">
              <button type="reset" class="btn btn-outline-secondary"><i class="fas fa-undo mr-1"></i> Reset</button>
              <button type="submit" class="btn btn-dark">
                <i class="fas fa-save mr-1"></i> Update
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  @endsection
