<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Admin Markdown' }}</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body>
  @include('components.admin-header')
  <section class="container-fluid">
    @yield('content')
  </section>
</body>
</html>
