@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/addeditrole') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">用户组名称</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="display_name" value="{{ isset($name) ? $name : old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">权限设置</label>

                            <div class="col-md-6">
                            @if ($permissions)
                                @foreach ($permissions as $item)
                                <label><input name="permission[]" type="checkbox" value="{{$item['id']}}" />{{$item['display_name']}}</label>
                                <ul>
                                    @if (isset($item['sub']))
                                    @foreach ($item['sub'] as $per)
                                        <li><label><input name="permission[]" type="checkbox" value="{{$per['id']}}" />{{ $per['display_name'] }}</label></li>
                                     @endforeach
                                    @endif
                                </ul>
                                @endforeach
                            @endif
                               <!--  @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif -->
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
