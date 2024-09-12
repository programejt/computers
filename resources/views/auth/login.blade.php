@extends('layout')

@section('content')

  <section class="container mw-400">
    <h1 class="text-center">Zaloguj się</h1>
    <form action="{{route('authenticate')}}" method="post">
      @csrf
      <div class="mb-3"><label class="form-label" for="login">Login</label> <input type="text" id="login" class="form-control" name="login" placeholder="Login"></div>
      <div class="mb-4"><label class="form-label" for="password">Hasło</label> <input type="password" id="password" class="form-control" name="password" placeholder="Hasło"></div>
      <div class="d-grid text-center"><button type="submit" class="btn btn-primary">Zaloguj</button></div>
    </form>
  </section>

@endsection