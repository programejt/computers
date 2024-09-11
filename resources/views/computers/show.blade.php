@push('styles')
    <link href="{{ URL::asset('css/computer.min.css') }}" rel="stylesheet">
@endpush

@extends('layout')

@section('content')

  @if ($comp != null)
    <section class="container mw-800 computer">
      <header class="computer-header mb-4 text-center">
        <a href="/computer/{{$comp->id}}" class="h1 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{$comp->name}}</a>
        <div class="user-name mb-3">
          <a href="{{route('user.show', ['user' => $comp->user_id])}}" class="link text-darker">{{$comp->user_name}}</a>
        </div>
        @if (Auth::id() == $comp->user_id)
          <div class="computer-buttons">
            <a href="{{route('computer.edit', ['id' => $comp->id])}}" class="btn btn-secondary">Edytuj</a>
            <a href="{{route('computer.delete', ['computer' => $comp->id])}}" class="btn btn-danger">Usuń</a>
          </div>
        @endif
      </header>
      @if (($photo = $comp->getPhoto()) != null)
        <section class="computer-photo mb-4">
          <img src="/{{$photo}}" alt="komputer" class="img-rounded">
        </section>
      @endif
      <section class="computer-components">

        <!-- <div class="row my-3 justify-content-center">
          <div class="col-3"></div>
          <div class="col-6"></div>
        </div> -->
        <ul class="container computer-components-ul">
          @foreach ($compComponents as $component)
            <li class="row computer-component">
              <div class="col-12 col-sm-4 component-type">{{$component->type_name}}</div>
              <div class="col-12 col-sm-8 component-name">{{$component->component_name}}</div>
            </li>
          @endforeach
        </ul>
      </section>
    </section>
  @else
    <div class="fs-1 text-center">Nie ma takiego komputera :(</div>
  @endif

@endsection