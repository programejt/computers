@extends('layout')

@section('content')

  <section class="container">
    <h1>Zaloguj się</h1>
    <form action="/authenticate" method="post">
      @csrf
      <div><label for="">Login</label> <input type="text" class="form-control" name="login" placeholder="Login"></div>
      <div><label for="">Hasło</label> <input type="password" class="form-control" name="password" placeholder="Hasło"></div>
      <div><button type="submit" class="btn btn-primary">Zaloguj</button></div>
    </form>
  </section>

@endsection