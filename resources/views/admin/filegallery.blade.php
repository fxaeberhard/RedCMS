{!! Form::model($model, ['url' => 'Gallery/'.$model->id, 'class' => 'form', 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    @include('admin.pageblock')

    <div class="form-group">
      <!-- {!! Form::label('pictures', 'Pictures:', ['class' => 'control-label']) !!} -->

      <div class="admin-list admin-file-list admin-track-list" data-sortable>
        @foreach($model->items as $i)
          <div class="admin-list-item">
            <i class="fa fa-reorder"></i>
            <div class="input-group">
              <input class="form-control" type="text" name="items.url" value="{{$i->url}}">
              <span class="input-group-btn">
                <button class="btn btn-red" data-toggle="filemanager"><i class="fa fa-folder"></i></button>
                <button class="btn btn-red" data-remove=".admin-list-item"><i class="fa fa-trash"></i></button>
              </span>
            </div>
            <div class="input-group">
              <input class="form-control" type="text" name="items.description_en" value="{{$i->description_en }}" placeholder="Title (Optional, file name will be used by default)">
            </div>
            <!-- <img id="holder" style="margin-top:15px;max-height:100px;"> -->
            {!! Form::hidden('items.id', $i->id) !!}
          </div>
        @endforeach
      </div>
      <div class="clearfix"></div>

      <button type="button" class="btn btn-red btn-round btn-lg" data-append=".admin-list"><i class="fa fa-plus"></i></button>
      <script type="tpl">
        <div class="admin-list-item">
          <i class="fa fa-reorder"></i>
          <div class="input-group">
            <input class="form-control" type="text" name="items.url">
            <span class="input-group-btn">
              <button class="btn btn-red" data-toggle="filemanager"><i class="fa fa-folder"></i></button>
              <button class="btn btn-red" data-remove=".admin-list-item"><i class="fa fa-trash"></i></button>
            </span>
          </div>
          <div class="input-group">
            <input class="form-control" type="text" name="items.description_en" value="{{$i->description_en }}" placeholder="Title (Optional, file name will be used by default)">
          </div>
          {!! Form::hidden('items.id', null) !!}
        </div>
      </script>
      <!--
        <div class="admin-list-item">
          <a href="#" data-toggle="filemanager"></a>
          {!! Form::hidden('items.url', null) !!}
          {!! Form::hidden('items.id', null) !!}
          <button class="btn btn-red btn-round btn-sm" data-toggle="filemanager"><i class="fa fa-trash"></i></button>
          <button class="btn btn-red btn-round btn-sm" data-remove=".admin-list-item"><i class="fa fa-trash"></i></button>
        </div>-->

      <span class="help-block">Drag and drop to order files.</span>

    </div>

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
