@extends('layouts.admin')

@section('content')
<!--左侧导航结束-->
<div class="content-wrapper">
    <el-row id="config">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>欢迎!</el-breadcrumb-item>
        </el-breadcrumb>
        
    </el-row>
</div>

<script type="text/javascript">
    var index = new Vue({
        el: '#index',
        data: {
            order_index : '{{ $bkAdminUri }}'
        },
    });
</script>
@endsection

