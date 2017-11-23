{!! Form::model($model, ['url' => 'Blog/'.$model->id, 'class' => 'form', 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    @include('admin.pageblock')

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
