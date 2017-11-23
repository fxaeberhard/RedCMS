{!! Form::model($model, ['url' => 'Gallery/'.$model->id, 'class' => 'form', 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    @include('admin.pageblock')

    <div class="form-group">
      <!-- {!! Form::label('pictures', 'Pictures:', ['class' => 'control-label']) !!} -->

      <div class="admin-list admin-picture-list" data-sortable>
        @foreach($model->items as $i)
          <div class="admin-list-item">
            <img src="{{url('upload/'.$i->url)}}" tite="{{$i->url}}" data-toggle="upload">
            {!! Form::hidden('items.url', $i->url) !!}
            {!! Form::hidden('items.id', $i->id) !!}
            <button class="btn btn-red btn-round btn-sm" data-remove=".admin-list-item"><i class="fa fa-trash"></i></button>
          </div>
        @endforeach
      </div>
      <div class="clearfix"></div><br>

      <button type="button" class="btn btn-red btn-round btn-lg" data-append=".admin-list"><i class="fa fa-plus"></i></button>
      <script type="tpl">
        <div class="admin-list-item">
          <img src="{{url('upload/icon-upload.png')}}" data-toggle="upload">
          {!! Form::hidden('items.url', 'icon-upload.png') !!}
          {!! Form::hidden('items.id', null) !!}
          <button class="btn btn-red btn-round btn-sm" data-remove=".admin-list-item"><i class="fa fa-trash"></i></button>
        </div>
      </script>

      <span class="help-block">Drag and drop to order pictures.</span>

    </div>

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
