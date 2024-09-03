@extends('layout')

@section('content')

  <section class="container">
    <div class="row g-3">
    @foreach ($computers as $c)
      <div class="card col-sm-6 col-lg-4">
        <img src="images/desktop_computer.jpg" class="card-img-top" alt="Computer">
        <div class="card-body">
          <h2 class="card-title">{{$c->computer_name}}</h2>
          <p class="card-text">{{$c->user_name}}</p>
          <a href="/computer/{{$c->computer_id}}" class="btn btn-primary mx-auto">Zobacz specyfikację</a>
        </div>
      </div>
    @endforeach
    </div>
  </section>

@endsection