@extends('mobile.layout.app')
@section('content')
    @if (Auth::guest())
    <div class="myinfo">
         <div class="container">
                <a href="{{url('mobile/login')}}">
                    <div class="pull-left usercenter">
                        <div class="myphoto"> <img src="/homestyle/m_img/logo-t.png" class="img-responsive img-circle"> </div>
                        <div class="mylogin">
                            <p class="login-title">点击登陆</p>
                            <p>登录后更精彩</p>
                        </div>
                    </div>
                    <div class="pull-right right-g"> <img src="/homestyle/m_img/R.png" class=" img-responsive"> </div>
                </a>
            </div>
    </div>

    @else
        <div class="myinfo">
            <div class="container">
                <a href="{{route('mobile.user.info')}}">
                    <div class="pull-left usercenter">
                        <div class="myphoto">
                            <img src="{{$userinfo->thumb}}" class="img-responsive img-circle">
                        </div>
                        <div class="mylogin">
                            <p class="login-title">
                                @if(empty($userinfo->name))
                                    {{$userinfo->oauth->nickname}}
                                @else
                                    {{$userinfo->name}}
                                @endif
                            </p>
                            <p>{{$userinfo->phone}}</p>
                        </div>
                    </div>
                    <div class="pull-right right-g"> <img src="/homestyle/m_img/R.png" class=" img-responsive"> </div>
                </a>
            </div>
        </div>
        <div class="my-gz">
            <ul>
                <a href="{{route('mobile.follow')}}">
                    <li>
                        <p class="gz-num"> {{App\Models\Follow::where('my_id',$userinfo->id)->count()}} </p>
                        <p style="color:#999;">关注</p>
                    </li>
                </a>
                <li style="border:0px;">
                    <p class="gz-num"> {{App\Models\Follow::where('user_id',$userinfo->id)->count()}} </p>
                    <p style="color:#999;">粉丝</p>
                </li>
            </ul>
        </div>
        @endif

    <div class="mylist">
        <div class=" container">
            @if (Auth::guest())
                <div class="row">
                    <ul>
                        <li>
                            <a class="auth">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i1.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p> 我的钱包</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                        <li>
                            <a class="auth">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i2.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p>我的资料</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                        <li>
                            <a class="auth">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i3.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p> 我的关注</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img">
                                    <img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>

                        <li>
                            <a class="auth">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i3.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p> 我的粉丝</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img">
                                    <img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                    </ul>
                    <ul>

                        <li>
                            <a class="auth">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i5.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p>申请主播</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="{{route('mobile.system')}}">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i6.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p>设置</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                    </ul>
                </div>
                @else
                <div class="row">
                    <ul>
                        <li>
                            <a  href="{{route('mobile.pay')}}">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i1.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p> 我的钱包</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('mobile.user.info')}}">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i2.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p>我的资料</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('mobile.follow')}}">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i3.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p> 我的关注</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img">
                                    <img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('mobile.fans')}}">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i3.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p> 我的粉丝</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img">
                                    <img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                    </ul>
                    <ul>
                        @if($userinfo->type == 1)
                            <li>
                                <a class="lecturer">
                                    <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                        <div class="list-img"> <img src="/homestyle/m_img/i5.png" class="img-responsive"> </div>
                                        <div class="list-txt">
                                            <p>申请主播</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                                </a>
                            </li>
                        @endif
                    </ul>
                    <ul>
                        <li>
                            <a href="{{route('mobile.system')}}">
                                <div class="col-lg-5 col-md-5 col-sm-9 col-xs-9 pull-left">
                                    <div class="list-img"> <img src="/homestyle/m_img/i6.png" class="img-responsive"> </div>
                                    <div class="list-txt">
                                        <p>设置</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right right-img"><img src="/homestyle/m_img/R1.png" class="img-responsive"></div>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
        </div>
    </div>
    @include('mobile.layout.footer')
    @stop
@section('js')
    <script>
        $(function(){
            $('.lecturer').click(function(){
                layer.open({
                    content: '请登陆构牛PC端提交申请！'
                    ,btn: '我知道了'
                });
            });

            $('.auth_phone').click(function(){
                layer.open({
                    content: '您已经绑定手机了，无需再次绑定！'
                    ,btn: '我知道了'
                });
            });
        })
    </script>
    @stop