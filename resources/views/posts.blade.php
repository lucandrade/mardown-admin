@extends('layouts.default')

@section('content')
  @foreach ($posts as $post)
    <div class="card mt-4">
      <div class="card-body">
        {!! $post->html_content !!}
      </div>
    </div>
  @endforeach
@endsection