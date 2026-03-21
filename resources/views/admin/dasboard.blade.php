@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('css')

@endsection



@section('content_header')

@endsection

@section('content')
  <div class="row">

    {{-- Pending Approvals --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $pendingCourses }}</h3>
          <p>Pending Approvals</p>
        </div>

        <div class="icon">
          <i class="fas fa-check-circle"></i>
        </div>

        <a href="{{ route('admin.course_approvals.index') }}" class="small-box-footer">
          View Details <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>


    {{-- Total Enrollments --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $totalEnrollments }}</h3>
          <p>Total Enrollments</p>
        </div>

        <div class="icon">
          <i class="fas fa-user-graduate"></i>
        </div>

        <a href="{{ route('admin.courses.enroll_all') }}" class="small-box-footer">
          View Details <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>


    {{-- Total Courses --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $totalCourses }}</h3>
          <p>Total Courses</p>
        </div>

        <div class="icon">
          <i class="fas fa-book-open"></i>
        </div>

        <a href="" class="small-box-footer">
          Manage Courses <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>


    {{-- Total Teachers --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $totalTeachers }}</h3>
          <p>Total Teachers</p>
        </div>

        <div class="icon">
          <i class="fas fa-users"></i>
        </div>

        <a href="{{ route('admin.users.index') }}" class="small-box-footer">
          View Teachers <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    {{-- Total Students --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $totalStudents }}</h3>
          <p>Total Students</p>
        </div>

        <div class="icon">
          <i class="fas fa-users"></i>
        </div>

        <a href="{{ route('admin.users.index') }}" class="small-box-footer">
          View Students <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

  </div>
@endsection

@section('js')

@endsection
