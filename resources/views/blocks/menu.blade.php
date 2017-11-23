<div class="menu">

  <div class="hd"></div>

  <div class="navbar">
    <ul class="nav navbar-nav" data-sortable="/MenuItem/Sort" data-sortable-handle=">  a">
      @foreach ($block->items as $item)

        <?php if ($item->id == 68 && Auth::user()->belongsToGroup(2)) { break; } ?>

        @if ($item->type == 'category')
          <li class="dropdown" data-model="MenuItem" data-model-id="{{$item->id}}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$item->label()}}</a>
            <ul class="dropdown-menu" role="menu" data-sortable="/MenuItem/Sort">
              @foreach ($item->items as $sub)
                <li data-model="MenuItem" data-model-id="{{$sub->id}}" >
                  <a href="{{$sub->href()}}" class="@if ($sub->active()) active @endif">
                    {{ $sub->label() }}
                  </a>
                </li>
              @endforeach
              @if (!Auth::guest() && Auth::user()->isAdmin())
                <button class="btn btn-round btn-red pull-right" data-toggle="redmodal" data-url='add?model=MenuItem&data={"menu_item_id":"{{$item->id}}","type":"link"}' title="Add link">
                  <i class="fa fa-plus"></i>
                </button>
              @endif
            </ul>
          </li>

        @else
          <?php $link = $item->type == "link" ? page($item->page) : url($item->target); ?>
          <li data-model="MenuItem" data-model-id="{{$item->id}}"><a href="{{$item->href()}}" class="@if ($item->active()) active @endif" >
            {{ $item->label() }}
          </a></li>

        @endif
      @endforeach
    </ul>

    @if (!Auth::guest() && Auth::user()->isAdmin())
      <div class="admin dropdown">
        <button type="button" class="btn btn-round btn-red pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-plus"></i>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#" data-toggle="redmodal" data-url='add?model=MenuItem&data={"menu_id":"{{$block->id}}","type":"link"}'>Add link</a></li>
          <li><a href="#" data-toggle="redmodal" data-url='add?model=MenuItem&data={"menu_id":"{{$block->id}}","type":"category"}'>Add submenu</a></li>
          <li><a href="#" data-toggle="redmodal" data-url='add?model=MenuItem&data={"menu_id":"{{$block->id}}","type":"login"}' class="debug">Add login/logout link</a></li>
          <!-- <li><a href="#" data-toggle="redmodal" data-url='add?model=MenuItem&data={"menu_id":"{{$block->id}}","type":"freelink"}' class="debug">Add free link</a></li> -->
        </ul>
      </div>
    @endif
  </div>

  <div class="ft"></div>

</div>
