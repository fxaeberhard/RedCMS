<div class="admin-pages">
  <button class="btn btn-red btn-round" data-toggle="redmodal" data-url='add?model=Page' title="New page">
    <div class="fa-wrapper">
      <i class="fa fa-file-o"></i>
      <i class="fa fa-plus"></i>
    </div>
    New page
  </button>
  @foreach ($pages as $p)
    <div data-model="Page" @unless ($p->locked) data-model-id="{{$p->id}}" @endunless><a href="{{page($p)}}">{{$p->name()}}</a></div>
  @endforeach
</div>
