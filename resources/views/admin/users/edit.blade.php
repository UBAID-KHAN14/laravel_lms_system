@extends('adminlte::page')

@section('title', 'Edit User')

@include('messages.toast')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
      <i class="fas fa-user-edit mr-1"></i> Edit User
    </h1>

    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm">
      <i class="fas fa-arrow-left"></i> Back to Users
    </a>
  </div>
@stop

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <form action="{{ route('admin.users.update_user', $user->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- BASIC INFORMATION --}}
          <div class="card card-primary card-outline mb-4">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-id-card mr-1"></i> Basic Information
              </h3>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                      value="{{ old('name', $user->name) }}" placeholder="Enter full name">
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                      value="{{ old('email', $user->email) }}" placeholder="Enter email">
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                      <option value="">Select role</option>
                      <option value="admin" @selected($user->role === 'admin')>Admin</option>
                      <option value="teacher" @selected($user->role === 'teacher')>Teacher</option>
                      <option value="student" @selected($user->role === 'student')>Student</option>
                    </select>
                    @error('role')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- SECURITY --}}
          <div class="card card-warning card-outline mb-4">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-lock mr-1"></i> Security
              </h3>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                      placeholder="Leave blank to keep current password">
                    <small class="text-muted">
                      Leave empty if you don’t want to change the password
                    </small>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                      placeholder="Confirm password">
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- ADDITIONAL DETAILS --}}
          <div class="card card-info card-outline mb-4">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-info-circle mr-1"></i> Additional Details
              </h3>
            </div>

            <div class="card-body">
              <div class="form-group">
                <label>Requested As</label>
                <select name="requested_as" class="form-control @error('requested_as') is-invalid @enderror">
                  <option value="">Select Request As</option>
                  <option value="teacher" @selected($user->requested_as === 'teacher')>Teacher</option>
                  <option value="student" @selected($user->requested_as === 'student')>Student</option>
                </select>
              </div>

              <div class="form-group">
                <label>Profile Image</label>
                <input type="file" name="image" class="form-control">

                @if ($user->image)
                  <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->image) }}" width="100" class="img-thumbnail">
                  </div>
                @endif
              </div>
            </div>
          </div>

          {{-- ACTION BAR --}}
          <div class="card">
            <div class="card-footer text-right">
              <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Cancel
              </a>

              <button type="submit" class="btn btn-dark px-4">
                <i class="fas fa-save"></i> Save User
              </button>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
@endsection
