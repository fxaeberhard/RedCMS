{!! Form::model($model, ['url' => 'BlogComment/'.$model->id, 'class' => '___form-horizontal', 'data-submit' => $model->id ?'put': 'post']) !!}

  <fieldset>

   {!! Form::hidden('blog_post_id') !!}

    @foreach (locales() as $k => $l)
      <div class="form-group">
        <!-- {!! Form::label('description', 'Text '.$k, ['class' => 'control-label']) !!} -->
        {!! Form::textarea('text', null, ['class' => 'form-control rte', 'id' => 'text', 'required' => true]) !!}
        <!-- <span class="help-block">Use <kbd>shift +  &crarr;</kbd> to add small line break</span> -->
        <div class="help-block with-errors"></div>
      </div>
    @endforeach

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
