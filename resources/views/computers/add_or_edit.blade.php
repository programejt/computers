@php($title .= ' komputer')

@push('scripts')
  <script src="{{ URL::asset('js/computer_add_or_edit.min.js') }}"></script>
@endpush

@extends('layout')

@section('content')
<section class="container mw-800">
  <header class="text-center">
    <h1>{{$h1}} komputer</h1>
    @if ($computer != null)
      <a href="{{route('computer.show', ['id' => $computer->id])}}" class="fs-1 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{$computer->name}}</a>
    @endif
  </header>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{route('computer.store')}}" method="post" enctype="multipart/form-data">
    @method($formMethod)
    @csrf

    @if ($computer != null)
      <input type="hidden" name="computer-id" value="{{$computer->id}}">
    @endif
    <section class="my-5">
      <h2>Podstawowe informacje</h2>
      <div class="row justify-content-center">
        <div class="col-12 col-sm-4"><label class="col-form-label" for="">Nazwa komputera</label></div>
        <div class="col-12 col-sm-8"><input type="text" class="form-control" placeholder="Nazwa komputera" name="computer-name" value="{{$computer?->name}}"></div>
      </div>
    </section>
    <section class="my-5">
      <h2>Zdjęcie</h2>
      @if ($computer != null)
        @if (($photo = $computer->getPhoto()) != null)
          <div class="text-center mb-3"><img class="img-rounded mw-400" src="/{{$photo}}" alt="Zdjęcie komputera"></div>
          <div class="text-center mb-3"><label><input type="checkbox" name="delete-computer-photo" id="computer-photo-checkbox"> Usuń zdjęcie</label></div>
        @endif
      @endif
      <div class="row justify-content-center">
        <div class="col-12 col-sm-4"><label class="col-form-label" for="">Zdjęcie</label></div>
        <div class="col-12 col-sm-8"><input type="file" id="computer-photo-input-file" class="form-control" name="computer-photo" accept=".jpg,.jpeg,.png,.webp"></div>
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