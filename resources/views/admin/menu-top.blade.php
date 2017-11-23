<div class="redcms-adminmenu btn-group">
  <div class="btn-group">
    <button class="btn btn-red dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup=true aria-expanded=false>
      Admin <span class=caret></span>
    </button>
     <ul class="dropdown-menu">
      @if (isset($page))
      <!-- <li><a href="#" data-toggle="redmodal" data-url="edit?model=Page&modelId={{$page->id}}">Edit current page</a></li> -->
      @endif
      <li><a href="#" data-toggle="redmodal" data-url="Page" data-size="md">Pages</a></li>
      <li><a href="#" data-toggle="redmodaliframe" data-url="laravel-filemanager">Files</a></li>
      <li><a href="#" data-toggle="redmodaliframe" data-url="laravel-filemanager?type=Images">Images</a></li>
      <li><a href="#" data-toggle="redmodal" data-url="User" data-size="lg">Users</a></li>
      <li><a href="#" data-toggle="redmodal" data-url="Group" data-size="md">Groups</a></li>
      <!-- <li><a href=#>Backups</a></li> -->
      <li role="separator" class="divider"></li>
      <li><a href={{url('logout')}}>Logout</a></li>
    </ul>
  </div>
  <!-- <div class="btn-group">
    <button class="btn btn-red dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup=true aria-expanded=false>
      Users <span class=caret></span>
    </button>
     <ul class="dropdown-menu">
        <li><a href=#>Users</a></li>
        <li><a href=#>Groups</a></li>
        <li><a href=#>Mailing list</a></li>
    </ul>
  </div> -->
</div>

{{-- <div class="redcms-adminmenu">
  <ul class="nav nav-pills" role=tablist>
    <!-- <li role=presentation class=active><a href=#>Regular link</a></li> -->
    <li role=presentation class=dropdown>
      <a href=# class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup=true aria-expanded=false> Content <span class=caret></span> </a>
      <ul class="dropdown-menu">
        <li><a href="#" data-toggle="redmodal" data-url="{{url('Page')}}">Pages</a></li>
        <li><a href="#" data-toggle="redmodaliframe" data-url="laravel-filemanager">Files</a></li>
        <li role="separator" class="divider"></li>
        <li><a href={{url('logout')}}>Logout</a></li>
      </ul>
    </li>
  </ul>
</div> --}}
