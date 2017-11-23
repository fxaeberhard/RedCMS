<div class="calendar">

  <div class="fullcalendar"></div>

  @if (!Auth::guest())
    <button class="btn btn-default btn-primary" data-toggle="redmodal" data-url='add?model=CalendarEvent&data={"calendar_id":{{$block->id}}}'>
      <i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Ajouter un événement
    </button>
  @endif

  <?php
    $past = app('request')->exists('past');
    $events = $past ? $block->pastEvents() : $block->futurEvents();

    if (app('request')->exists('import')) {
      importCongresses($block->id);
    }
  ?>

  @if (isset($page))
    @if ($past)
      <a href="{{page($page)}}" class="pull-right margin-top-1">Current events</a>
    @else
      <a href="{{page($page)}}?past" class="pull-right margin-top-1">Past events</a>
    @endif
  @endif

  @foreach ($events->get() as $event)
    <div class="panel panel-default event"  data-model="CalendarEvent" data-model-id="{{$event->id}}">
      <div class="panel-heading">
        <i class="fa fa-newspaper-o fa-2x" aria-hidden="true"></i>
        <h3>{{$event->title}}</h3>
        <span class="sub">
          {{formatPeriod($event->date, $event->dateend)}}
          @if ($event->location) à {{$event->location}} @endif
        </span>
      </div>

      <div class="panel-body">
        {!!trim($event->description)!!}
        @if ($event->link)
          <a href="{{$event->link}}" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i> {{$event->link}}</a>
        @endif
      </div>

      @if (!Auth::guest())
        <!-- <a href="#" data-toggle="redmodal" data-url='add?model=BlogComment&data={"caledendar_event_id":{{$event->id}}}'> -->
          <!-- Comment -->
        <!-- </a> -->
      @endif
    </div>
  @endforeach
</div>

@push('head')
  <link rel="stylesheet" href="{{url('bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
@endpush

@push('scripts')
  <script src="{{url('bower_components/moment/min/moment.min.js')}}"></script>
  <script src="{{url('bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>
@endpush
