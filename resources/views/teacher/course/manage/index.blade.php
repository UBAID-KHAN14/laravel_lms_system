@extends('teacher.layouts.course-builder')

@section('content')
  @include('messages.toast')
  @includeIf('teacher.course.manage.' . $tab)
@endsection
