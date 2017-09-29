<!--header-->
<div class="navbar" style="margin:0px; background:#fff;">
    <div class="navbar-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="pull-left"><span class="navbar-txt">您好，欢迎来到构牛财经直播平台！</span></div>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <ul class="usermenu">
                            @if (Auth::guest())
                                <li class="openlogin"><a data-toggle="modal" href="#login-modal">登录</a></li>
                                <li class="reg"><a data-toggle="modal" href="#login-modal">注册</a></li>
                            @else
                                <li><a href="{{url('logout')}}">退出</a></li>
                                @if(empty($userinfo->name))
                                    <li><a href="{{route('user')}}"> {{$userinfo->oauth->nickname}}</a></li>
                                    @else
                                    <li><a href="{{route('user')}}"> {{$userinfo->name}}</a></li>
                                    @endif
                            @endif
                        </ul>
                        <div class="modal my-css-modal" id="login-modal" style="height:600px;">
                            <div class="login">
                                <div class="header">
                                    <div class="switch" id="switch">
                                        <a class="switch_btn_focus" id="switch_qlogin" href="javascript:void(0);"
                                           tabindex="7">快速登录</a>
                                        <a class="switch_btn" id="switch_login" href="javascript:void(0);" tabindex="8">快速注册</a>
                                        <div class="switch_bottom" id="switch_bottom"
                                             style="position: absolute; width: 64px; left: 0px;"></div>
                                    </div>
                                    <a class="close" data-dismiss="modal"></a></div>

                                @include('home.auth.login')
                                @include('home.auth.register')
                            </div>
                        </div>
                        <!--登陆注册-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container nav-con">
        <div class="navbar-header pull-left logo1"><a href="{{route('home')}}" class="navbar-brand">
                <img  src="{{$siteinfo['logo']}}" width="200" height="47"></a>
        </div>
        <div class=" navbar-collapse collapse">
            
            <ul class="nav navbar-nav">
                <li class="{{$_index or ''}}"><a href="{{route('home')}}">首页</a></li>
                <li class="{{$_living or ''}}"><a href="{{route('living')}}">正在直播</a></li>
                <li class="{{$_back_live or ''}}"><a href="{{route('back.live')}}">直播回看</a></li>
                <li class="{{$_master_view or ''}}"><a href="{{route('master.view')}}">高手观点</a></li>
                <li class="{{$_delivery or ''}}"><a href="{{route('delivery')}}">交割单</a></li>
            </ul>
            <div class="nav-search">
                @if (!Auth::guest())
                <div style="float:right;" class="nav-my"><a href="{{route('user')}}">
                        <span class="pull-left">
                              @if(empty($userinfo->oauth))
                                  @if(empty($userinfo->thumb))
                            <img class="img-circle" src="/homestyle/images/admin.png" width="36" height="34"></span>
                        @else
                            <img class="img-circle" src="{{$userinfo->thumb}}" width="36" height="34"></span>
                        @endif
                        @else
                            <img class="img-circle" src="{{$userinfo->oauth->avatar_url}}" width="36" height="34"></span>
                        @endif
                        <span class="mytxt">我的</span>
                    </a>
                </div>
                @endif
                <div class="jsearch-box">
                    <form method="get" action="/search">
                        <input type="text" name="name" placeholder="输入搜索内容" class="jsearch-text" required/>
                        <button type="submit" class="btnGoSearch"></button>
                    </form>
                </div>
                <div class="nav-line"></div>
            </div>
        </div>
    </div>
</div>

<!--heade结束-->