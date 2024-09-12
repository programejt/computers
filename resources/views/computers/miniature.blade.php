<div class="col-sm-6 col-lg-4">
  <div class="card computer">
    <div class="card-image">
      @if ($photo == null)
        @php ($photo = 'images/computer-icon.png')
      @endif
      <img src="/{{$photo}}" class="card-img-top" alt="{{$name}} - komputer">
    </div>
    <div class="card-body">
      <h2 class="card-title">{{$name}}</h2>
      <p class="card-text"><a href="{{route('user.show', ['user' => $userId])}}" class="link text-darker">{{$userName}}</a></p>
      <div class="text-center">
        <a href="{{route('computer.show', ['id' => $id])}}" class="btn btn-primary">Zobacz specyfikację</a>
      </div>
    </div>
  </div>
</div>