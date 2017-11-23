<div class="admin-pages">
  <button class="btn btn-red" data-toggle="redmodal" data-url='add?model=User' title="New user">
    <div class="fa-wrapper">
      <i class="fa fa-user"></i>
      <i class="fa fa-plus"></i>
    </div>
    New user
  </button>
  @foreach ($users as $u)
    <div data-model="User" data-model-id="{{$u->id}}" class="row">
      <div class="col-sm-5">
        {{$u->firstname}} {{$u->lastname}}
      </div>
      <div class="col-sm-6 hidden-xs truncate text-muted">
        {{$u->groups->implode('name', ', ')}}
      </div>
    </div>
  @endforeach
</div>
