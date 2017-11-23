{!! Form::model($model, ['url' => 'Page/'.$model->id, 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    @foreach (locales() as $k => $l)
      <div class="form-group">
        <input name="name_{{$l}}" id="name_{{$l}}" value="{{$model["name_$l"]}}" required class="form-control" />
        <label for="name_{{$l}}">Title {{$k}}</label>
        <div class="help-block with-errors"></div>
      </div>
    @endforeach

    @foreach (locales() as $k => $l)
    <div class="form-group debug">
      <input name="title_{{$l}}" id="title_{{$l}}" value="{{$model["title_$l"]}}" class="form-control" />
      <label for="title_{{$l}}">Header title {{$k}}</label>
      <span class="help-block">Leave blank to use title</span>
      <div class="help-block with-errors"></div>
    </div>
    @endforeach

    @foreach (locales() as $k => $l)
      <div class="form-group debug">
        <textarea name="description_{{$l}}" id="description_{{$l}}" value="{{$model["description_$l"]}}" class="form-control autosize" rows=1></textarea>
        <label for="description_{{$l}}">Description {{$k}}</label>
        <span class="help-block">Used in search engine results</span>
        <div class="help-block with-errors"></div>
      </div>
    @endforeach

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
