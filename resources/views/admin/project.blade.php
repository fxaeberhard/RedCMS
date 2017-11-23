{!! Form::model($model, ['url' => 'Project/'.$model->id, 'class' => 'form-horizontal', 'data-submit' => $model->id ?'put': 'post']) !!}
 
  <fieldset>
    {!! Form::hidden('portfolio_id') !!}

    <div class="form-group">
      {!! Form::label('title', 'Title:', ['class' => 'col-lg-2 control-label']) !!}
      <div class="col-lg-10">
          {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'email', 'required' => true]) !!}
      </div>
    </div>

    <div class="form-group">
      {!! Form::label('description', 'Description:', ['class' => 'col-lg-2 control-label']) !!}
      <div class="col-lg-10">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'description', 'required' => true]) !!}
      </div>
    </div>

    <div class="form-group">
      {!! Form::label('thumbnail', 'Picture:', ['class' => 'col-lg-2 control-label']) !!}
      <div class="col-lg-10">
        <div class="admin-picture">
          <div>
            <img src="{{url('upload/'.$model->thumbnail)}}" tite="{{$model->thumbnail}}" data-toggle="upload">  
            {!! Form::hidden('thumbnail', null) !!}
          </div>
          <div>
            {!! Form::select('thumbnail_size', ['1-2' => 'Large', '1-3' => 'Small', '2-2' => 'Tall'], null, ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      {!! Form::label('pictures', 'Other pictures:', ['class' => 'col-lg-2 control-label']) !!}
      <div class="col-lg-10">
              
        <div class="pictures-list">
          @foreach($model->pictures as $picture)
            <div class="admin-picture">
              <div>
                <img src="{{url('upload/'.$picture->url)}}" tite="{{$picture->url}}" data-toggle="upload">  
                {!! Form::hidden('pictures.url', $picture->url) !!}
              </div>
              <div>
                {!! Form::select('pictures.size', ['1-2' => 'Large', '1-3' => 'Small', '2-2' => 'Tall'],  $picture->size, ['class' => 'form-control']) !!}
                <i class="fa fa-trash" data-remove=".admin-picture"></i>
              </div>
              {!! Form::hidden('pictures.id', $picture->id) !!}
            </div>
          @endforeach
        </div>

        <button type="button" class="btn btn-default" data-append=".pictures-list"><i class="fa fa-plus"></i></button>
        <script type="tpl">
          <div class="admin-picture">
            <div>
              {!! Form::hidden('pictures.id', null) !!}
              <img src="{{url('upload/icon-upload.png')}}" data-toggle="upload">
              {!! Form::hidden('pictures.url', 'icon-upload.png') !!}
            </div>
            <div>
              {!! Form::select('pictures.size', ['1-2' => 'Large', '1-3' => 'Small', '2-2' => 'Tall'],  null, ['class' => 'form-control']) !!}
              <i class="fa fa-trash" data-remove=".admin-picture"></i>
            </div>
          </div>
        </script>
      </div>
    </div>

    @include('admin.buttons')
 
  </fieldset>
 
{!! Form::close()  !!}
 