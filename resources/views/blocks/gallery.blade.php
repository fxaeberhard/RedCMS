<div class="gallery clearfix" data-sortable="/GalleryItem/Sort">
  @foreach ($block->items as $i)
    <div data-model-id="{{$i->id}}" data-model="GalleryItem">
      <a href="{{url('imgp/upload/'.$i->url.'?w=1400&nu')}}" @if ($i->credit or $i->description()) data-sub-html=".caption" @endif>
        <img src="{{url('imgp/upload/'.$i->url.'?w=200&h=200&nu')}}">
        @if ($i->credit or $i->description())
          <div class="caption">
            {!! $i->description() !!}
            @if ($i->credit and $i->description()) <br> @endif
            @if ($i->credit) &copy;{{$i->credit}} @endif
          </div>
        @endif
      </a>
   {{-- <div class="text-center credits">
        @if ($i->credit) ©{{$i->credit}} @endif
      </div>--}}
    </div>
  @endforeach
</div>

@if (!Auth::guest() && Auth::user()->isAdmin())
  <div>
    <br>
    <button class="btn btn-default btn-red" data-toggle="redmodal" data-url='add?model=GalleryItem&data={"gallery_id":{{$block->id}}}' title="Add picture">
      <i class="fa fa-plus"></i> Add picture
    </button>
    <span class="help-block">Drag and drop to order pictures.</span>
  </div>
@endif

<div class="clearfix"></div>

@push('head')
  <link type="text/css" rel="stylesheet" href="{{url('bower_components/lightgallery/dist/css/lightgallery.min.css')}}" />
@endpush

@push('scripts')
  <script src="{{url('bower_components/lightgallery/dist/js/lightgallery.min.js')}}"></script>
  <script>
    $(document).on('loaded.red.gallery', function() {
        $(".gallery").lightGallery({ selector: 'a', subHtmlSelectorRelative: true });
    }).trigger('loaded.red.gallery');
  </script>
@endpush
