{!! Form::model($model, ['url' => 'User/'.$model->id, 'data-submit' => $model->id ? 'put' : 'post']) !!}

  <fieldset>

    @include('admin.user-fields')
    
    @include('admin.buttons')

  </fieldset>
{!! Form::close()  !!}
