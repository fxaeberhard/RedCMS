<div class="activity panel panel-default margin-top-0">
	<div class="panel-heading">
		<h3>Activité récente sur le site</h3>
	</div>

	<?php
			$posts = App\BlogPost::limit(10)->orderBy('created_at')->get();
			$calendar = App\CalendarEvent::limit(10)->orderBy('created_at')->get();
			$items = $posts->merge($calendar)->all();
			usort($items, function ($a, $b) {
				return $a->created_at < $b->created_at;
			});
			array_splice($items, 7);
	?>

	@foreach ($items as $item)
		@if ($item instanceof App\BlogPost)
			<?php $page = $item->blog->page(); ?>
			<a href="{{page($page)}}">
				<i class="fa fa-newspaper-o fa-fw fa-2x"></i>
				<span class="category">{{$page->name()}}</span>
				<span class="title truncate">{{$item->title}}</span>
				<span class="sub">posté le {{formatDate($item->created_at)}} par {{$item->user->name()}}</span>
			</a>

		@else
			<?php $page = $item->calendar->page(); ?>
			<a href="{{page($page)}}">
				<i class="fa fa-calendar fa-fw fa-2x"></i>
				<span class="category">{{$page->name()}}</span>
				<span class="title truncate">{{$item->title}}</span>
				<span class="sub">à {{$item->location}} {{formatPeriod($item->date, $item->dateend)}}, posté le {{formatDate($item->created_at)}}</span>
			</a>

		@endif

	@endforeach

</div>
