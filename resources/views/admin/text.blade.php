{!! Form::model($model, ['url' => 'Text/'.$model->id, 'class' => '___form-horizontal', 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    @include('admin.pageblock')

    @foreach (locales() as $k => $l)
      <div class="form-group">
        <!-- {!! Form::label('content_'.$l, 'Text '.$k, ['class' => 'control-label']) !!} -->
        {!! Form::textarea('content_'.$l, null, ['class' => 'form-control rte', 'id' =>  'content_'.$l, 'required' => true]) !!}
        <!-- <span class="help-block">Use <kbd>shift +  &crarr;</kbd> to add small line break</span> -->
        <div class="help-block with-errors"></div>
      </div>
    @endforeach

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
