{!! Form::open(['url' => 'login', 'class' => 'form-horizontal', 'data-submit' => 'login']) !!}

  <fieldset>

    <div class="form-group">
      {!! Form::label('email', 'E-mail:', ['class' => 'col-lg-3 control-label']) !!}
      <div class="col-lg-9">
          {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => '', 'required' => true, 'autofocus' => true]) !!}
      </div>
    </div>

    <div class="form-group">
      {!! Form::label('password', 'Password:', ['class' => 'col-lg-3 control-label']) !!}
      <div class="col-lg-9">
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '', 'required' => true]) !!}
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-9 col-lg-offset-3">
        <div class="checkbox">
          <label>
            {!! Form::checkbox('remember', 'value', true) !!} Remember me
          </label>
        </div>
      </div>
    </div>

    @include('admin.buttons', ['label' => 'Login'])
 
  </fieldset>
 
{!! Form::close() !!}
 