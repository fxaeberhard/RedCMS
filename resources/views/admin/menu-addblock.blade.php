@if (!Auth::guest() && Auth::user()->isAdmin())
  <div class="dropup pull-right">
    <button type=button class="btn btn-round btn-red" data-toggle=dropdown aria-haspopup=true aria-expanded=false>
      <i class="fa fa-plus"></i>
    </button>
    <ul class="dropdown-menu">
      <li><a href="#" data-toggle="redmodal" data-url='add?model=Text&data={"pageBlock":{"page_id":"{{$page->id}}"}}'>Text</a></li>
      <li><a href="#" data-toggle="redmodal" data-url='add?model=Calendar&data={"pageBlock":{"page_id":"{{$page->id}}"}}'>Calendar</a></li>
      <li><a href="#" data-toggle="redmodal" data-url='add?model=Blog&data={"pageBlock":{"page_id":"{{$page->id}}"}}'>News</a></li>
      <li><a href="#" data-toggle="redmodal" data-url='add?model=Form&data={"pageBlock":{"page_id":"{{$page->id}}","view":"blocks.form-contact"}}'>Contact form</a></li>
      <li><a href="#" data-toggle="redmodal" data-url='add?model=SimpleBlock&data={"pageBlock":{"page_id":"{{$page->id}}","view":"blocks.simpleblock","admin_view":"admin.block"}}' class="debug">Block</a></li>
      <li><a href="#" data-toggle="redmodal" data-url='add?model=Gallery&data={"pageBlock":{"page_id":"{{$page->id}}"}}' class="debug">Gallery</a></li>
      <li><a href="#" data-toggle="redmodal" data-url='add?model=Form&data={"pageBlock":{"page_id":"{{$page->id}}"}}' class="debug">Form</a></li>
      <!-- <li><a href="#" data-toggle="redmodal" data-url='add?model=FileList&data={"__page_id":"{{$page->id}}"}'>Track list</a></li> -->
      <!-- <li class="show"><a href="#" data-toggle="redmodal" data-url='add?model=Gallery&data={"pageBlock":{"page_id":"{{$page->id}}","view":"blocks.filegallery","admin_view":"admin.filegallery"}}'>Songs gallery</a></li> -->
    </ul>
  </div>
  <div class=clearfix></div>
@endif
