@extends('layouts.admin')
@section('content')
  <div id="app">
    <post-form></post-form>
  </div>
  <script>
    window.postData = @json($post ?? []);
  </script>
@endsection
