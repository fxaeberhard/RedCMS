{!! Form::model($model, ['url' => 'BlogPost/'.$model->id, 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    {!! Form::hidden('blog_id', null) !!}

    @foreach (locales() as $k => $l)
      <div class="form-group">
        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'required' => true]) !!}
        {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
        <div class="help-block with-errors"></div>
      </div>
    @endforeach

    @foreach (locales() as $k => $l)
      <div class="form-group">
        <!-- {!! Form::label('text', 'Text', ['class' => 'control-label']) !!} -->
        {!! Form::textarea('text', null, ['class' => 'form-control rte', 'id' => 'text', 'required' => true]) !!}
        <!-- <span class="help-block">Use <kbd>shift +  &crarr;</kbd> to add small line break</span> -->
        <div class="help-block with-errors"></div>
      </div>
    @endforeach

    <div class="form-group debug">
      {!! Form::text('created_at', null, ['class' => 'form-control', 'data-toggle' => 'datetimepicker', 'id' => 'created_at']) !!}
      {!! Form::label('created_at', 'Date', ['class' => 'control-label']) !!}
      <div class="help-block with-errors"></div>
    </div>

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
