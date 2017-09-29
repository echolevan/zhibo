@extends('home.layout.app')
@section('content')
    <div class=" container">
        <div class="row">
            <div class="change">
                <div class="step">
                    <div class="steptit">修改登录密码</div>
                    <div class="bind2">
                        <div class="stepimg3"></div>
                        <div class="steptxt">
                            <span class="s1">设置密码</span>
                            <span class="s3" style="left:125px;">完成</span>
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