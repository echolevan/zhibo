<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>构牛直播</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{configInfo()['ico']}}">
    <link href="{{asset('homestyle/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('homestyle/m_css/style.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('homestyle/js/jquery.min.js')}}"></script>
    <script src="{{asset('homestyle/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('homestyle/m_js/myslideup.js')}}"></script>
    <link href="{{asset('homestyle/layer/need/layer.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('homestyle/layer/layer.js')}}"></script>
    <script>
        urlredirect();
        function urlredirect() {
            var sUserAgent = navigator.userAgent.toLowerCase();
            if (!(sUserAgent.match(/(ipod|iphone os|midp|ucweb|android|windows ce|windows mobile)/i))) {
                // PC跳转移动端
                var thisUrl = window.location.href;
                window.location.href = thisUrl.substr(0, thisUrl.lastIndexOf('/') + 1);

            }
        }
    </script>
    <style>
        @font-face {
            font-family:"iconfont";
            src: url('fonts/iconfont.eot'); /* IE9*/
            src: url('fonts/iconfont.eot#iefix') format('embedded-opentype'), /* IE6-IE8 */ url('fonts/iconfont.woff') format('woff'), /* chrome, firefox */ url('fonts/iconfont.ttf') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+*/ url('fonts/iconfont.svg#iconfont') format('svg'); /* iOS 4.1- */
        }
        .iconfont {
            font-family:"iconfont" !important;
            font-style:normal;
            -webkit-font-smoothing: antialiased;
            -webkit-text-stroke-width: 0.2px;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
    <link href="{{asset('homestyle/m_css/admin.css')}}" rel="stylesheet" type="text/css">
    @yield('css')
    <script type="text/javascript">
        $(function(){
            $(".line").slideUp();
            $('#myCarousel').carousel({
                //自动4秒播放
                interval : 4000,
            });

        })
    </script>

</head>

<body @if(\Route::currentRouteName() == 'mobile') style="background:#f5f5f5; @endif">
@yield('content')


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