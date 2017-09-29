@extends('home.layout.app')
@section('content')
    <div class="container user">
        <div class="row">
            @include('home.user.menu')
            <!--右侧-->
            <div class="pull-right userright">
                <h3><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的资料</h3>
                <div class="rightcon">
                    <ul>
                        <li>
                            <div class="pull-left">
                                <span class="myinfo"><img src="/homestyle/images/myinfo1.png" width="36" height="36"></span>
                                <span class="mytxt">个人信息</span>
                                <span class="mydetail">您可以修改昵称/头像/个人简介</span>
                            </div>
                            <div class="pull-right">
                                <a href="{{route('userinfo')}}" class="rightbtn">修改</a>
                            </div>
                        </li>
                        <li>
                            <div class="pull-left">
                                <span class="myinfo"><img src="/homestyle/images/myinfo2.png" width="36" height="36"></span>
                                <span class="mytxt">登录密码</span>
                                <span class="mydetail">登录平台所输的密码，建议您定期更改</span>
                            </div>
                            <div class="pull-right">
                                <a href="{{route('user.change.password')}}" class="rightbtn">修改</a>
                            </div>
                        </li>
                        <li>
                            <div class="pull-left">
                                <span class="myinfo"><img src="/homestyle/images/myinfo3.png" width="36" height="36"></span>
                                <span class="mytxt">手机号码</span>

                            </div>
                            <div class="pull-right">
                                @if(empty($userinfo->phone))
                                <a href="{{route('user.bind_phone')}}" class="rightbtn">绑定</a>
                                    @else
                                    <div style="margin-right:33px; " class="carryimg"><img  src="/homestyle/images/carryout.png" width="30" height="32"></div>
                                @endif
                            </div>
                        </li>

                    </ul>
                    <div class="rightbotom"></div>
                </div>
            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
