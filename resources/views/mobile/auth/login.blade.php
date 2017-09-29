@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border:none;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="{{url('mobile/customer')}}"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;"><img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">登录</a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right"><a href="{{route('mobile')}}"><span style=" height:24px; display:block; float:right; margin-top:0px; margin-right:10px; color:#ff4436;"></span></a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="bindphone" style="margin-top:50px;">
    <div class="login"><img src="/homestyle/m_img/pic.png" class="img-responsive img-circle"></div>
    <form>
        <div class="input-name">
            <input type="text" name="username" placeholder="请输入昵称或手机号码">
        </div>
        <div class="input-group input-name" style="margin-top:20px;">
            <input type="password" id="password" placeholder="请输入密码">
      <span class="input-group-btn">
       <a href="{{route('mobile.forget.password')}}">
           <button class="btn btn-default yzm" type="button">忘记密码</button>
       </a>

      </span>
        </div>
        <p><a  href="javascript:void (0);" class="btn bind-btn m_do_login">登录</a></p>
        <p style="width:150px;display: block;margin: 10px auto;"><a href="{{url('mobile/register')}}">没有账号？立即注册</a></p>
    </form>
</div>
@include('mobile.auth.oauth')
<!--主界面内容end-->
@stop
@section('js')
    @include('mobile.auth.login_register_js')
@stop