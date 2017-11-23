<div class="filelist">
	@foreach ($block->items as $f)
      <a href="{{url($f->url)}}"><i class="fa fa-play-circle"></i> {{$f->description_en ?? filename($f->url)}}</a>
    @endforeach
</div>