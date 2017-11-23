<div class="admin-pages">
  <button class="btn btn-red" data-toggle="redmodal" data-url='add?model=Group'>
    <div class="fa-wrapper">
      <i class="fa fa-users"></i>
      <i class="fa fa-plus"></i>
    </div>
    New group
  </button>
  @foreach ($groups as $g)
    <div data-model="Group" data-model-id="{{$g->id}}">{{$g->name}}</div>
  @endforeach
</div>
