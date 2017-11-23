{!! Form::model($model, ['url' => 'CalendarEvent/'.$model->id, 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    {!! Form::hidden('calendar_id', null) !!}

    <div class="form-group">
      {!! Form::text('title', null, ['class' => 'form-control', 'required' => true, 'id' => 'title']) !!}
      {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
      <div class="help-block with-errors"></div>
    </div>

    <div class="form-group">
      {!! Form::text('date', null, ['class' => 'form-control', 'required' => true, 'data-toggle' => 'datetimepicker', 'id' => 'date']) !!}
      {!! Form::label('date', 'Start date', ['class' => 'control-label']) !!}
      <div class="help-block with-errors"></div>
    </div>

    <div class="form-group">
      {!! Form::text('dateend', null, ['class' => 'form-control', 'data-toggle' => 'datetimepicker', 'id' => 'dateend', 'placeholder' => 'optional']) !!}
      {!! Form::label('dateend', 'End date', ['class' => 'control-label']) !!}
      <div class="help-block with-errors"></div>
    </div>

    <div class="form-group">
      {!! Form::url('link', null, ['class' => 'form-control', 'id' => 'link']) !!}
      {!! Form::label('link', 'Link', ['class' => 'control-label']) !!}
      <div class="help-block with-errors"></div>
    </div>

    <div class="form-group">
      {!! Form::text('location', null, ['class' => 'form-control', 'id' => 'location']) !!}
      {!! Form::label('location', 'Location', ['class' => 'control-label']) !!}
      <div class="help-block with-errors"></div>
    </div>

    <div class="form-group">
      {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
      {!! Form::textarea('description', null, ['class' => 'form-control rte', 'id' => 'description']) !!}
      <!-- <span class="help-block">Use <kbd>shift +  &crarr;</kbd> to add small line break</span> -->
      <div class="help-block with-errors"></div>
    </div>

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
