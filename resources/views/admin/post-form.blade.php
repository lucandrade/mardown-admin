@extends('layouts.admin')
@section('content')
  @if(session('success'))
    <div class="alert alert-success mt-4">
      {{ session('success') }}
    </div>
  @endif
  @if(session('errors'))
    <div class="alert alert-danger mt-4">
      @foreach(session('errors')->all() as $error)
        {{ $error }}<br />
      @endforeach
    </div>
  @endif
  <div id="app">
    <post-form></post-form>
  </div>
  <script>
    window.postData = @json($post ?? []);
  </script>
@endsection
