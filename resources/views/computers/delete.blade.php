@extends('layout')

@section('content')
  <section class="container container-small text-center">
    <header class="mb-3">
      <h1 class="text-center mb-3">Usuń komputer</h1>
      <a href="{{route('computer.show', ['id' => $computerId])}}" class="fs-1 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{$computerName}}</a>
    </header>
    <form action="{{route('computer.remove')}}" method="post">
      @method('delete')
      @csrf

      <input type="hidden" name="computer-id" value="{{$computerId}}">

      <div class="justify-content-center">
        <a href="{{route('computer.show', ['id' => $computerId])}}" class="btn btn-secondary">Anuluj</a>
        <button type="submit" class="btn btn-danger">Usuń komputer</button>
      </div>
    </form>
  </section>
@endsection