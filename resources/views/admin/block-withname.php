{!! Form::model($model, ['url' => 'Block/'.$model->id, 'class' => 'form-horizontal', 'data-submit' => $model->id ? 'put': 'post']) !!}

    <fieldset>

        <!-- <legend>Legend</legend> -->
        <div class="form-group">
            {!! Form::label('name', 'Text:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'text']) !!}
            </div>
        </div>

        @include('admin.buttons')

    </fieldset>

{!! Form::close()  !!}
