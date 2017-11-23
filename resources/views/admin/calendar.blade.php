{!! Form::model($model, ['url' => 'Calendar/'.$model->id, 'class' => '___form-horizontal', 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    @include('admin.pageblock')

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
