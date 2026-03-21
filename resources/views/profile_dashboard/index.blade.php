@extends('adminlte::page')
@section('title', 'Profile Dashboard')
@include('messages.toast')
@section('content_header')
  <h1>Profile Dashboard</h1>
@stop
@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center" style="border-top: 3px solid #0D82FF">
            @if (Auth::user()->image)
              <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}"
                class="img-fluid rounded-circle mb-3"
                style="width: 150px; height: 150px; border: 2px solid #d2d6de; padding: 2px; background-color: white;">
            @else
              <div class="d-flex justify-content-center">
                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
                  style="width:150px;height:150px; font-size:60px; border: 2px solid #d2d6de; padding: 2px; background-color: white;">
                  {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
              </div>
            @endif
            <h4>{{ Auth::user()->name }}</h4>
            <p>{{ Auth::user()->email }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header" style="border-top: 3px solid #0D82FF">Profile Details</div>
          <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('POST')
              <div class="row">
                <div class="col-md-12">
                  <label>Profile Photo:</label>
                  <input type="file" class="form-control" name="image">
                </div>
                <div class="col-md-6">
                  <label>Name:</label>
                  <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name">
                </div>
                <div class="col-md-6">
                  <label>Email:</label>
                  <input type="text" class="form-control" value="{{ Auth::user()->email }}" readonly>
                </div>
                <div class="col-md-12 mt-3 text-right">
                  <button type="reset" class="btn btn-outline-secondary mr-2">
                    <i class="fas fa-undo mr-1"></i> Reset
                  </button>
                  <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save mr-1"></i> Update Profile
                  </button>
                </div>
              </div>
            </form>
            <!-- Add more profile details as needed -->
          </div>
        </div>
        <div class="card">
          <div class="card-header">Change Password</div>
          <div class="card-body">
            <form action="{{ route('password.update') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <label>Current Password:</label>
                  <input type="password" class="form-control" name="current_password">
                </div>
                <div class="col-md-6">
                  <label>Password:</label>
                  <input type="password" class="form-control" name="password">
                </div>
                <div class="col-md-6">
                  <label>Confirm Password:</label>
                  <input type="password" class="form-control" name="password_confirmation">
                </div>
              </div>
              <div class="col-md-12 mt-3 text-right">
                <button type="reset" class="btn btn-outline-secondary mr-2">
                  <i class="fas fa-undo mr-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-dark">
                  <i class="fas fa-save mr-1"></i> Update Password
                </button>
              </div>
            </form>

            <div class="mt-4">
              {{-- DANGER ZONE --}}
              <div class="profile-card border-danger border p-4 text-center">
                <h5 class="text-danger mb-3">
                  <i class="fa fa-triangle-exclamation"></i> Danger Zone
                </h5>

                <p class="text-muted">
                  Deleting your account will permanently remove all your data.
                </p>

                <form action="{{ route('profile.destroy') }}" method="POST" id="deleteForm">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-danger" id="deleteBtn">
                    <i class="fa fa-trash"></i> Delete Account
                  </button>
                </form>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script>
    document.getElementById('deleteBtn').addEventListener('click', function() {
      if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
      }
    });
  </script>
@endsection
