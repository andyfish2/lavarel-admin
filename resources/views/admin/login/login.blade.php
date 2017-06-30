<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>管理后台</title>

    <link rel="stylesheet" href="{{ asset('css/admin/plugin/element-index.css') }}">
    <link rel="stylesheet" href="http://at.alicdn.com/t/font_71vi4rkgsbdquxr.css">
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
</head>
<body>
<div class="wrapper" id="index">
    <!--登录-->
    <div class="login-dialog" v-cloak>
        <div class="head">
            <div class="head-big-font">
                管理后台
            </div>
        </div>
        <div class="login-body">
            <div class="login-title">
                <h3>账号登录</h3>
                <!-- <h5 class="gray">账号登录</h5> -->
            </div>
            <br>
            <div class="login-form">
                <el-form :model="loginForm" :rules="loginRules" ref="loginForm" label-width="100px" label-position="top" action="{{ url('admin/login') }}" method="POST" class="demo-ruleForm" id="loginForm">
                    {{ csrf_field() }}
                    <el-form-item label="用户名" prop="account">
                        <el-input type="text" v-model="loginForm.account" name="name" auto-complete="off" ></el-input>
                        @if ($errors->has('name'))
                        <div class="el-form-item__error">{{ $errors->first('name') }}</div>
                         @endif
                    </el-form-item>
                    <el-form-item label="密码" prop="pass">
                        <el-input type="password"  v-model="loginForm.pass" name="password" auto-complete="off" ></el-input>
                        @if ($errors->has('password'))
                        <div class="el-form-item__error">{{ $errors->first('password') }}</div>
                        @endif
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="userloginForm('loginForm','')"
                                   style="width: 100%">登录
                        </el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/admin/jquery.min.js') }}"></script>
<script src="{{ asset('js/admin/vue.min.js') }}"></script>
<script src="{{ asset('js/admin/element-index.js') }}"></script>
<script type="text/javascript">
    var index = new Vue({
        el: '#index',
        data: {
            loginForm: {
                account: '{{ old("name") }}',
                pass: ''
            },
            loginRules: {
                account: [
                    {required: true, message: '请填写用户名', trigger: 'blur'},
                ],
                pass: [
                    {required: true, message: '请填写密码', trigger: 'blur'},
                ]
            },
        },
        methods: {
            userloginForm: function (formName,confirm) {
                var _this = this;
                this.$refs[formName].validate(function (valid) {
                    if (valid) {
                        var form = document.getElementById(formName); //this.submit();
                        form.submit();
                    }
                });
            },
        }
    });
</script>
</body>
<!-- <script src="{{ asset('js/admin/style.js') }}"></script> -->
</html>