<!DOCTYPE HTML>
<html @if(\Route::currentRouteName() == 'live') class="g1920" @endif>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>@yield('meta_title',$siteinfo['title'])</title>
    <meta name="keywords" content="@yield('meta_keywords',$siteinfo['keyword'])">
    <meta name="description" content="@yield('meta_description',$siteinfo['content'])">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('homestyle/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('homestyle/css/index.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('homestyle/css/login.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/layer/skin/default/layer.css')}}">
    <link rel="icon" type="image/png" href="{{$siteinfo['ico']}}">
    <script src="{{asset('homestyle/js/jquery.min.js')}}"></script>
    <script href="{{asset('homestyle/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script>
        urlredirect();
        function urlredirect() {
            var sUserAgent = navigator.userAgent.toLowerCase();
            if ((sUserAgent.match(/(ipod|iphone os|midp|ucweb|android|windows ce|windows mobile)/i))) {
                // PC跳转移动端
                var thisUrl = window.location.href;
                window.location.href = thisUrl.substr(0, thisUrl.lastIndexOf('/') + 1) + 'mobile';

            }
        }

    </script>
    <link href="{{asset('homestyle/css/Password.css')}}" rel="stylesheet" type="text/css">
    @if(\Route::currentRouteName() != 'live')
    <link href="{{asset('homestyle/css/admin.css')}}" rel="stylesheet" type="text/css">
    @endif
    @yield('css')
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?0225256eab0fe31bfcb081c519278157";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body id="div_frame_body">
@include('home.layout.header')
@include('home.layout.msg')
@if(\Route::currentRouteName() == 'live')
    @yield('content')
@else
    <div class="container-fluid">
        @yield('content')
    </div>
    <div class="clear"></div>
    @include('home.layout.footer')
    @endif

<script src="{{asset('homestyle/js/jq22.js')}}"></script>
<script src="{{asset('homestyle/js/login.js')}}"></script>
<script type="text/javascript" src="{{asset('homestyle/js/modal.js')}}"></script>
<script src="{{asset('assets/layer/layer.js')}}"></script>
<script src="{{asset('/homestyle/js/placeholder.js')}}"></script>
<script type="text/javascript">
    $(function () {
// Invoke the plugin
        $('input, textarea').attr('placeholder');

        $('.reg').click(function(){
            $('#switch_login').click();
        })
        $('.openlogin').click(function(){
            $('#switch_qlogin').click();
        })
    });
    jsPlaceHolder.play("username");
    jsPlaceHolder.play("username1");
    jsPlaceHolder.play("password");
    jsPlaceHolder.play("password1");
    jsPlaceHolder.play("password2");
    jsPlaceHolder.play("message");
</script>
@include('home.auth.login_register_js')
@yield('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
</body>
</html>
