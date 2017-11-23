{!! Form::model($model, ['url' => 'GalleryItem/'.$model->id, 'class' => 'form-horizontal', 'data-submit' => $model->id ? 'put': 'post']) !!}

  <fieldset>

    {!! Form::hidden('gallery_id', null) !!}

   <div class="form-group">
      {!! Form::label('url', 'Picture', ['class' => 'control-label col-lg-2' ]) !!}
      <div class="col-lg-10">
        <img src="{{url($model->url ? 'upload/'.$model->url : 'icon-upload')}}" tite="{{$model->url}}" data-toggle="upload">
        {!! Form::hidden('url', null) !!}
      </div>
    </div>

    <div class="form-group">
      {!! Form::label('credit', 'Credits', ['class' => 'control-label col-lg-2' ]) !!}
      <div class="col-lg-10">
        {!! Form::text('credit', null, ['class' => 'form-control']) !!}
      </div>
    </div>

    @foreach (locales() as $k => $l)
      <div class="form-group">
        {!! Form::label('description_'.$l, 'Description '.$k.':', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
          {!! Form::textarea('description_'.$l, null, ['class' => 'form-control']) !!}
        </div>
      </div>
    @endforeach

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
