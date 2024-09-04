@push('styles')
    <link href="{{ URL::asset('css/computers.min.css') }}" rel="stylesheet">
@endpush

@extends('layout')

@section('content')

  <section class="container">
    <div class="row g-3">
    @foreach ($computers as $c)
      <div class="col-sm-6 col-lg-4">
        <div class="card computer">
          <img src="images/desktop_computer.jpg" class="card-img-top" alt="Computer">
          <div class="card-body">
            <h2 class="card-title">{{$c->computer_name}}</h2>
            <p class="card-text text-darker">{{$c->user_name}}</p>
            <div class="text-center">
              <a href="/computer/{{$c->computer_id}}" class="btn btn-primary">Zobacz specyfikację</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    </div>
  </section>

@endsection