<h3>{{$subject}}</h3>

<p>
  {{$text}}
</p>

@foreach ($inputs as $k => $v)
  @if (substr($k, 0, 1) !== "_")
    {{str_replace("_", " ", $k)}}: {{$v}}<br />
  @endif
@endforeach
