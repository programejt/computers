<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>{{$title}} - Komputery</title>

      <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
      <link rel="stylesheet" href="{{ URL::asset('css/main.min.css') }}">
      @stack('styles')

      <script src="{{ URL::asset('js/app.js') }}"></script>
  </head>
  <body>
    <header id="main-header">
      <nav>
        <a class="nav-link" href="/">Komputery</a>
        @if ($user != NULL)
          <a class="nav-link" href="/computer/add">Dodaj komputer</a>
        @endif
      </nav>
      <div class="user">
      @if ($user != NULL)
        <span class="user-name">{{$user->name}}</span>
        <a class="nav-link" href="/logout">Wyloguj</a>
      @else
        <a class="nav-link" href="/login">Zaloguj się</a>
      @endif
      </div>
    </header>
    <main>@yield('content')</main>
  </body>
</html>
