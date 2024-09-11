@push('styles')
    <link href="{{ URL::asset('css/computers.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/user.min.css') }}" rel="stylesheet">
@endpush

@extends('layout')

@section('content')
  <header class="mb-5 text-center">
    <h1>{{$user->name}}</h1>
    <div class="user-avatar"><img class="user-icon-img" src="/images/user-icon.png" alt="{{$user->name}} - obrazek"></div>
  </header>

  <section class="container computers">
    <div class="row g-3">
    @foreach ($computers as $c)
      @include('computers.miniature', [
        'id' => $c->id,
        'name' => $c->name,
        'userId' => $c->user_id,
        'userName' => $user->name
      ])
    @endforeach
    </div>
  </section>

@endsection