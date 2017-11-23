{!! Form::open(['url' => 'Text/'.$model->id, 'class' => 'form-horizontal', 'data-submit' => $model->id ?'put': 'post']) !!}

    <fieldset>
 
        <!-- <div class="form-group">
            {!! Form::label('content', 'Text:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('content', $value = $model->content, ['class' => 'form-control', 'placeholder' => 'text']) !!}
            </div>
        </div> -->

        <!-- Submit Button -->
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
            </div>
        </div>

    </fieldset>

{!! Form::close()  !!}
 