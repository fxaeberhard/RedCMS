{!! Form::model($model, ['url' => 'FileList/'.$model->id, 'class' => 'form-horizontal', 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    @include('admin.pageblock')

    <div class="form-group">
      {!! Form::text('directory', null, ['class' => 'form-control', 'placeholder' => 'Files in this directory will be listed', 'required' => true, 'id' => 'directory']) !!}
      {!! Form::label('directory', 'Directory:', ['class' => 'control-label']) !!}
    </div>

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
