@push('styles')
    <link href="{{ URL::asset('css/computer.min.css') }}" rel="stylesheet">
@endpush

@extends('layout')

@section('content')

  @if ($comp != null)
    <section class="container computer">
      <header class="computer-header mb-4">
        <a href="/computer/{{$comp->id}}" class="h1 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{$comp->name}}</a>
        <div class="user-name text-darker mb-3">{{$comp->user_name}}</div>
        @if (Auth::id() == $comp->user_id)
          <div class="computer-buttons">
            <a href="/computer/edit/{{$comp->id}}" class="btn btn-secondary">Edytuj</a>
            <a href="/computer/delete/{{$comp->id}}" class="btn btn-danger">Usuń</a>
          </div>
        @endif
      </header>
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
    <div>Taki komputer nie istnieje</div>
  @endif

@endsection