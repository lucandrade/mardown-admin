@foreach ($posts as $post)
  <p>{{ $post->html_content }}</p>
@endforeach