<select name="{{$name}}" id="{{$name}}" value="{{$value}}" class="form-control">
  <option value="" disabled selected>Choose...</option>
  @foreach (Lang::get('countries') as $k => $l)
    <option value="{{$k}}">{{$l}}</option>
  @endforeach
</select>
