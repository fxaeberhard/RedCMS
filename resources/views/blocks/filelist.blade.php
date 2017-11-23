<div class="filelist">
	@foreach (File::files("files/shares/" . $block->directory) as $f)
      <a href="{{url($f)}}"><i class="fa fa-play-circle"></i> {{filename($f)}}</a>
    @endforeach
</div>