{!! Form::model($model, ['url' => 'MenuItem/'.$model->id, 'class' => 'form-horizontafl', 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

    {!! Form::hidden("type", null) !!}
    {!! Form::hidden("menu_id", null) !!}
    {!! Form::hidden("menu_item_id", null) !!}

    @if ($model->type == "category")
      @foreach (locales() as $k => $l)
        <div class="form-group">
          {!! Form::text("label_$l", null, ['class' => 'form-control', 'required' => true, 'id' => "label_$l"]) !!}
          {!! Form::label("label_$l", "Text $k", ['class' => 'col-lg-2 control-label']) !!}
          <div class="help-block with-errors"></div>
        </div>
      @endforeach

    @elseif ($model->type == "link")
      <div class="row">
        <div class="col-sm-11">
          <div class="form-group">
            {!! Form::select("page_id", pagesList(), null, ['placeholder' => 'Pick a page', 'required' => true, 'class' => 'form-control']) !!}
            {!! Form::label("page_id", "Target page", ['class' => 'control-label']) !!}
            <div class="help-block with-errors"></div>
          </div>
        </div>
        <div class="col-sm-1 padding-0">
          <!-- <div class="btn-group btn-group-red"> -->
          <button class="btn btn-red margin-top-05" data-toggle="redmodal" data-url='add?model=Page' title="New page">
            <div class="fa-wrapper">
              <i class="fa fa-file-o"></i>
              <i class="fa fa-plus"></i>
            </div>
          </button>
          <button class="btn btn-red debug" data-toggle="redmodal" data-url='edit?model=Page&modelId=%form.select%' title="Edit this page">
            <i class="fa fa-edit"></i>
          </button>
        </div>
      </div>

    @else

      @foreach (locales() as $k => $l)
        <div class="form-group">
          {!! Form::text("label_$l", null, ['class' => 'form-control', 'required' => true, 'id' => "label_$l"]) !!}
          {!! Form::label("label_$l", "Text $k", ['class' => 'col-lg-2 control-label']) !!}
          <div class="help-block with-errors"></div>
        </div>
      @endforeach

      <div class="form-group">
        {!! Form::text("target", null, ['class' => 'form-control', 'required' => true, "id" => 'target']) !!}
        {!! Form::label("target", "Target", ['class' => 'col-lg-2 control-label']) !!}
        <div class="help-block with-errors"></div>
      </div>

    @endif

    @include('admin.buttons')

  </fieldset>

{!! Form::close() !!}
