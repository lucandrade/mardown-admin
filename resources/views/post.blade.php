@if($post)
  {{ $post->markdown_content }}-{{ $post->html_content }}
@endif