<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Admin Markdown' }}</title>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
</head>
<body>
  @include('components.admin-header')
  <section class="container">
    @yield('content')
  </section>
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
