{!! Form::model($model, ['url' => 'Form/'.$model->id, 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    @include('admin.pageblock')

<!--<div class="form-group">
      {!! Form::email('target', null, ['class' => 'form-control', 'placeholder' => 'Send mail to', 'required' => true, 'id' => 'target']) !!}
      {!! Form::label('target', 'Recipient', ['class' => 'control-label']) !!}
    </div> -->

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
