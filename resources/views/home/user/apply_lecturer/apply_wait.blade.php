@extends('home.layout.app')
@section('content')
    <div class=" container">
        <div class="row">
            <div class="change">
                <div class="step">
                    <div class="steptit">申请成为主播</div>
                    <div class="bind2">
                        <div class="stepimg3"></div>
                        <div class="steptxt">
                            <span class="s1">身份验证</span>
                            <span class="s3" style="left:125px;">官方审核</span>
                        </div>
                    </div>
                </div>
                <div class="carryout">
                    <div class="carrycon">
                        <div class="carryimg"><img src="{{asset('homestyle/images/sh.png')}}"></div>
                        <div class="carrytxt" style="color:#666;">资料提交成功，请耐心等待工作人员审核！</div>
                    </div>
                    <p class="stepbtn1"><a href="{{route('user')}}">返回</a></p>
                    <div class="clear"></div>
                    <p style="height:60px;"></p>
                </div>
            </div>
        </div>
    </div>
    <div style="height:60px;"></div>
    <!--修改密码结束-->
    <!--底部-->
    <div class="clear"></div>
@stop


