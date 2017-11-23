<div>

    {!! Form::open(['url' => '/files', 'class' => 'form-horizontal', 'files' => true]) !!}
    {!! Form::file('file') !!}
    {!! Form::submit('Upload', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
    {!! Form::close()  !!}

</div>