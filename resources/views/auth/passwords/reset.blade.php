@extends('layouts.app')

@section('content')
<div class="bread">Reset password</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <!-- <div class="panel panel-default"> -->
                <!-- <div class="panel-heading">Reset Password</div> -->

                <!-- <div class="panel-body"> -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form  role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <!-- <div class="col-md-6"> -->
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                                <label for="email" class="control-label">E-Mail Address</label>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            <!-- </div> -->
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <!-- <div class="col-md-6"> -->
                                <input id="password" type="password" class="form-control" name="password" required>
                                <label for="password" class="col-md-4 control-label">Password</label>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            <!-- </div> -->
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <!-- <div class="col-md-6"> -->
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                <label for="password-confirm" class="control-label">Confirm Password</label>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            <!-- </div> -->
                        </div>

                        <div class="form-group text-center">
                            <!-- <div class="col-md-6 col-md-offset-4"> -->
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            <!-- </div> -->
                        </div>
                    </form>
                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
</div>
@endsection
