@php($title .= ' komputer')

@extends('layout')

@section('content')
<section class="container">
  <header class="text-center">
    <h1>{{$h1}} komputer</h1>
    @if ($computerId != null)
      <a href="/computer/{{$computerId}}/" class="fs-1 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{$computerName}}</a>
    @endif
  </header>
  <form action="/computer/store" method="post">
    @method($formMethod)
    @csrf

    @if ($computerId != null)
      <input type="hidden" name="computer-id" value="{{$computerId}}">
    @endif
    <section class="my-5">
      <h2>Podstawowe informacje</h2>
      <div class="row justify-content-center">
        <div class="col-12 col-sm-4"><label class="col-form-label" for="">Nazwa komputera</label></div>
        <div class="col-12 col-sm-8"><input type="text" class="form-control" placeholder="Nazwa komputera" name="computer-name" value="{{$computerName}}"></div>
      </div>
    </section>
    <section class="my-5">
      <h2>Podzespoły</h2>
      @foreach ($componentsTypes as $type)
        <div class="row my-3 justify-content-center">
          <div class="col-12 col-sm-4"><label class="col-form-label" for="">{{$type->name}}</label></div>
          <div class="col-12 col-sm-8"><input type="text" class="form-control" placeholder="{{$type->name}}" name="component-{{$type->id}}" value="{{$type->value}}"></div>
        </div>
      @endforeach
    </section>

    <div class="text-center">
      <button type="submit" class="btn btn-primary">Zapisz komputer</button>
    </div>
  </form>
</section>
@endsection