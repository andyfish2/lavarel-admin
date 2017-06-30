<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
<style type="text/css">
<!--
.a,.b,.c,.d,.e,.f{
color: #999;
font-size: 12px;
text-align: center;
height: 20px;
line-height: normal;
list-style-type: none;
margin: 0px;
padding: 0px;
border-right-width: 1px;
border-bottom-width: 1px;
border-right-style: solid;
border-bottom-style: solid;
border-right-color: #f00;
border-bottom-color: #f00;
top: 100px;
}
ul { margin:0px; padding:0px;
float: none;
background-color: #0000FF;
clear: left;
}
.a{
width: 100px;
float: left;
}
.b{width: 100px;}
.c{width: 200px;}
.d{width: 200px;}
.e{width: 200px;}
.f{width: 50px;}
li{float: left;}
.h {
height: 42px;
width: 856px;
border-top-width: 1px;
border-left-width: 1px;
border-top-style: solid;
border-left-style: solid;
border-top-color: #0000FF;
border-left-color: #FF0000;
margin: 0px;
padding: 0px;
}
-->
</style>
</head>
<body><div class="h">
<ul>
<li class="a">日期</li>
<li class="b">新增用户数</li>
<li class="c">新增设备数</li>
<li class="d">活跃用户数</li>
<li class="e">活跃设备数</li>
<li class="f">充值总额</li>
</ul>
@foreach ($inside as $business)
<li class="a">{{ $business['day'] }}</li>
<li class="b">{{ $business['newUser'] }}</li>
<li class="c">{{ $business['newUUID'] }}</li>
<li class="d">{{ $business['activeUser'] }}</li>
<li class="e">{{ $business['activeUUID'] }}</li>
<li class="f">{{ isset($business['totalAmount']) ? $business['totalAmount'] : ''}}</li>
@endforeach
</div>
</body>
</html>