@extends('adminlte::page')

@section('title', 'Edit Sub Category')

@section('content_header')
  <h1 class="text-dark m-0">Edit Sub Category</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card card-warning card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-edit mr-1"></i>
            Edit Sub Category
          </h3>
        </div>

        <form action="{{ route('admin.sub_categories.update', $sub_category->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="card-body">

            <div class="form-group">
              <label for="category_id">Category</label>
              <select name="category_id" id="category_id" class="form-control">
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ $category->id == $sub_category->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="name">Sub Category Name</label>
              <input type="text" name="name" id="name" value="{{ $sub_category->name }}" class="form-control"
                placeholder="Enter sub category name">
            </div>

          </div>

          <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('admin.sub_categories.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left mr-1"></i> Back
            </a>

            <button type="submit" class="btn btn-warning">
              <i class="fas fa-save mr-1"></i> Update
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>
@endsection
