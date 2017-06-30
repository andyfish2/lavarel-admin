<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/admin/plugin/element-index.css') }}">
    <link rel="stylesheet" href="http://at.alicdn.com/t/font_71vi4rkgsbdquxr.css">
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <script src="{{ asset('js/admin/jquery.min.js') }}"></script>
    <script src="{{ asset('js/admin/vue.min.js') }}"></script>
    <script src="{{ asset('js/admin/element-index.js') }}"></script>
</head>

<body>
<div class="wrapper" id="index">
    <div v-cloak>
        <!--左侧导航开始-->
        <nav class="navBar fix default" role="navigation" id="menu" >
            <div class="nav-header">
                <h3>管理后台</h3>
                <br>
                <span class="db m-t-xs"><strong class="font-bold">你好！{{ $userInfo['name'] }}</strong></span>
                <el-button-group style="margin-top:4px;">
                    <el-button type="danger" size="mini">
                        <a href="password.html">
                            <i class="icon iconfont icon-change-password"></i>
                            修改密码
                        </a>
                    </el-button>
                    <el-button type="success" size="mini">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="icon iconfont icon-log_out"></i>退出
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </el-button>
                </el-button-group>
            </div>
            <el-menu id='menu_index' :default-active="order_index" theme="dark" class="el-menu-vertical-demo" @open="" @close="">
                <el-menu-item index="0"><a href="{{ route('admin_main') }}"><i class="icon iconfont icon-home7"></i> 首页</a></el-menu-item>
                @if ($menus)
                    @foreach ($menus as $menu)
                        <el-submenu index="{{ $menu['id'] }}" >
                            <template slot="title" >{{ $menu['display_name'] }}</template>
                            @if (isset($menu['sub']))
                            @foreach ($menu['sub'] as $m)
                            <a href="{{ url($m['name']) }}"><el-menu-item   index="{{ $m['name'] }}">{{ $m['display_name'] }}</el-menu-item></a>
                            @endforeach
                            @endif
                        </el-submenu>
                    @endforeach
                @endif
                <!-- <el-menu-item index="3"><a onclick="active()"><i class="icon iconfont icon-set"></i>
                    市场人员-扣量规则配置'</a></el-menu-item> -->
            </el-menu>
        </nav>
        @yield('content')
    </div>
</div>
</body>
</html>