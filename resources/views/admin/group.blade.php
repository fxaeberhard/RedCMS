{!! Form::model($model, ['url' => 'Group/'.$model->id, 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    <div class="form-group">
      <input name="name" id="name" value="{{$model->name}}" required class="form-control" placeholder=" "/>
      <label for="name">Name</label>
      <div class="help-block with-errors"></div>
    </div>

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
