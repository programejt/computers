<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>{{$title}} - Komputery</title>

      <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ URL::asset('css/main.min.css') }}">
      @stack('styles')

      <script src="{{ URL::asset('js/app.js') }}"></script>
  </head>
  <body>
    <header id="main-header">
      <nav class="navbar navbar-expand-sm">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Computers</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/">Komputery</a>
              </li>
              @if ($user != NULL)
                <li class="nav-item">
                  <a class="nav-link" href="/computer/add">Dodaj komputer</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{$user->name}}
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item fs-3" href="/logout">Wyloguj</a></li>
                  </ul>
                </li>
              @else
                <li class="nav-item">
                  <a class="nav-link" href="/login">Zaloguj się</a>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <main>@yield('content')</main>
  </body>
</html>
