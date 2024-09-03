@extends('layout')

@section('content')
  <section class="container">
    <header>
      <h1 class="text-center">Usuń komputer</h1>
      <a href="/computer/{{$computerId}}/" class="btn btn-secondary">{{$computerName}}</a>
    </header>
    <form action="/computer/remove" method="post">
      @method('delete')
      @csrf

      <input type="hidden" name="computer-id" value="{{$computerId}}">

      <div class="justify-content-center">
        <a href="/computer/{{$computerId}}/" class="btn btn-secondary">Anuluj</a>
        <button type="submit" class="btn btn-danger">Usuń komputer</button>
      </div>
    </form>
  </section>
@endsection