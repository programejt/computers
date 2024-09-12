@push('styles')
    <link href="{{ URL::asset('css/computers.min.css') }}" rel="stylesheet">
@endpush

@extends('layout')

@section('content')

  <section class="container computers">
    <div class="row g-3">
    @foreach ($computers as $c)
      @include('computers.miniature', [
        'id' => $c->id,
        'name' => $c->name,
        'userId' => $c->user_id,
        'userName' => $c->user_name,
        'photo' => $c->getPhoto()
      ])
    @endforeach
    </div>
  </section>

@endsection