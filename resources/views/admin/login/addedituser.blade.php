@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/addedituser') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">用户名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ isset($name) ? $name : old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">邮箱</label>

                            <div class="col-md-6">
                                <input id="password" type="email" class="form-control" name="email" value="{{ isset($email) ? $email : old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">用户组</label>

                            <div class="col-md-6">
                                <select name = 'role' class="form-control">
                                    <option value="">请选择</option>
                                    @if ($role)
                                        @foreach ($role as $item)
                                            <option value="{{ $item['id'] }}" @if (isset($roleId) && $item['id'] == $roleId) selected  @endif  @if (old('role') == $item['id']) selected  @endif> {{ $item['display_name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                 @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">状态</label>

                            <div class="col-md-6">
                                <input type="radio" name="status" value="0" @if (empty($status)) checked @endif @if (old('status') == 0) checked @endif>允许
                                <input type="radio" name="status" value="1" @if (!empty($status)) checked @endif @if (old('status') == 1) checked @endif>禁用

                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <input id="id" type="hidden" class="form-control" name="id" value= "{{ isset($id) ? $id : old('id') }}"
 required>
                        <div class="form-group">
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    保存
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
