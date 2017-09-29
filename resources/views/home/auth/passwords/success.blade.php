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
                <div class="step3">
                    <div class="stepimg3"></div>
                    <div class="steptxt">
                        <span class="s1">忘记密码</span>
                        <span class="s2">重置密码</span>
                        <span class="s3">完成</span>
                    </div>
                </div>
            </div>
            <div class="carryout">
                <div class="carrycon">
                    <div class="carryimg"><img src="/homestyle/images/carryout.png" width="30" height="32"></div>
                    <div class="carrytxt">密码设置成功，请您重新登录网站！</div>
                    <p class="second3"><span style="color:#ff4436;" id="time">5</span> 秒自动跳转首页</p>
                </div>
                <div class="clear"></div>
                <p style="height:60px;"></p>
            </div>
        </div>
    </div>
</div>
<div style="height:60px;"></div>
    @stop
@section('js')
    <script type="text/javascript">
        delayURL();
        function delayURL() {
            var delay = document.getElementById("time").innerHTML;
            var t = setTimeout("delayURL()", 1000);
            if (delay > 0) {
                delay--;
                document.getElementById("time").innerHTML = delay;
            } else {
                clearTimeout(t);
                window.location.href = "{{route('home')}}";
            }
        }
    </script>
    @stop