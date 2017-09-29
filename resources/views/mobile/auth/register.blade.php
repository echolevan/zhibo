@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border:none;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="{{url('mobile/login')}}"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;"><img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">注册</a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right"><a href="{{route('mobile')}}"><span style=" height:24px; display:block; float:right; margin-top:0px; margin-right:10px; color:#ff4436;"></span></a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="bindphone" style="margin-top:50px;">
    <form>
        <div class="input-name">
            <input type="text" name="name" placeholder="请输入昵称">
        </div>
        <div class="input-name" style="margin-top:20px;">
            <input type="text" name="phone" placeholder="请输入手机号">
        </div>
        <div class="input-group input-name" style="margin-top:20px;">
            <input type="text" name="code" placeholder="请输入验证码">
      <span class="input-group-btn">
        <button class="btn btn-default yzm send_code" type="button">获取验证码</button>
      </span>
        </div>
        <div class="input-name" style="margin-top:20px;">
            <input type="password" class="password" placeholder="请输入密码">
        </div>
        <div class="input-name" style="margin-top:20px;">
            <input type="password" class="confirmation" placeholder="请再次输入密码">
        </div>
        <p><a  href="javascript:void (0);" class="btn bind-btn m_do_register">注册</a></p>
        <p style="text-align:center; font-size:1em; margin-top:20px;"><span style="color:#999;">点击注册即代表您已经同意</span><br><a href="{{route('mobile.state')}}"><span style="color:#458cf5">《构牛用户注册协议》</span></a></p>
    </form>
</div>
@include('mobile.auth.oauth')
<!--主界面内容end-->
@stop
@section('js')
@include('mobile.auth.login_register_js')
    @stop