@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/resetspassword') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="old_password" class="col-md-4 control-label">原密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="old_password" value="{{ old('old_password') }}" required autofocus>

                                @if ($errors->has('old_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            <label for="new_password" class="col-md-4 control-label">新密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="new_password" value="{{ old('new_password') }}" required>

                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new_repeat_password') ? ' has-error' : '' }}">
                            <label for="new_repeat_password" class="col-md-4 control-label">确认新密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="new_repeat_password" value="{{ old('new_repeat_password') }}" required>

                                @if ($errors->has('new_repeat_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_repeat_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
