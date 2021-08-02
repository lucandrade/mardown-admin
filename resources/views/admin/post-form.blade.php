@extends('layouts.admin')
@section('content')
  <post-form></post-form>
  <script>
    window.postData = @json($post ?? []);
  </script>
@endsection
