@extends('home.layout.app')
@section('css')
    <link href="{{asset('homestyle/css/Password.css')}}" rel="stylesheet" type="text/css">
    @stop
@section('content')
    <div class=" container">
        <div class="row">
            <div class="change">
                <div class="step">
                    <div class="steptit">重置登录密码</div>
                    <div class="step1">
                        <div class="stepimg1"></div>
                        <div class="steptxt">
                            <span class="s1">忘记密码</span>
                            <span class="s2">重置密码</span>
                            <span class="s3">完成</span>
                        </div>
                    </div>
                </div>
                <div class="forgot">
                    <div>
                        <form>
                            <p>
                                <label>手机号：</label>
                                <input type="text" class="oldtext form-control mobile">
                            </p>
                            <div class="clear"></div>
                            <p>
                                <label>验证码：</label>
                                <input type="text" class="oldtext1 form-control imgcode">
                                <span class="v-code"><img class="code" src="{{ url('/captcha') }}" onclick="this.src='{{ url('/captcha') }}?r='+Math.random();" alt=""></span>
                            </p>
                            <div class="clear"></div>
                            <p>
                                <label>短信码：</label>
                                <input type="text" class="oldtext1 form-control mobilecode">
                                <span class="v-code"><a class="forget_send" href="javascript:void (0);">发送短信</a></span>
                            </p>
                        </form>
                    </div>
                    <div class="clear"></div>
                    <p class="stepbtn1 reset"><a href="javascript:void (0);">下一步</a></p>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
    <div style="height:60px;"></div>
    @stop
@section('js')
    @include('home.auth.passwords.reset_password_js')
    @stop