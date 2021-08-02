@extends('layouts.admin')

@section('content')
  @foreach ($posts as $post)
    <div class="card mt-4">
      <div class="card-body">
        {!! $post->html_content !!}
      </div>
      <div class="card-footer">
        <a href="/admin/{{ $post->id }}">Edit</a>
      </div>
    </div>
  @endforeach
@endsection