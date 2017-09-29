<div class="pull-left userleft">
    @include('home.user.user_content')
    <div class="menulist">
        <ul>
            <li class="{{$_lecturer or ''}}"><a href="{{route('lecturer_index')}}"><i><img src="{{asset('homestyle/images/userimg1.png')}}"></i> 直播室信息</a></li>
            <li class="{{$_relay or ''}}"><a href="{{route('relay.index')}}"><i><img src="{{asset('homestyle/images/userimg1.png')}}"></i> 我要转播</a></li>
            <li class="{{$_view or ''}}"><a href="{{route('lecturer.view')}}"><i><img src="{{asset('homestyle/images/userimg2.png')}}"></i> 我的观点</a></li>
            <li class="{{$_article or ''}}"><a href="{{route('lecturer.article')}}"><i><img src="{{asset('/homestyle/images/jiang-3.png')}}"></i> 我的文章</a></li>
            <li class="{{$_live_history or ''}}"><a href="{{route('history.live')}}"><i><img src="{{asset('homestyle/images/userimg4.png')}}"></i> 直播历史</a></li>
            <li class="{{$_relay_detail or ''}}"><a href="{{route('relay.detail')}}"><i><img src="{{asset('homestyle/images/userimg4.png')}}"></i> 转播明细</a></li>
            <li class="{{$_message or ''}}"><a href="{{route('lecturer.message')}}"><i><img src="{{asset('homestyle/images/userimg4.png')}}"></i> 处理提问</a></li>
            <li class="{{$_live_message or ''}}"><a href="{{route('live.message')}}"><i><img src="{{asset('homestyle/images/userimg5.png')}}"></i> 直播通知</a></li>
            <li class="{{$_play or ''}}"><a href="{{route('play')}}"><i><img src="{{asset('homestyle/images/userimg3.png')}}"></i> 开播停播</a></li>
            <li class="{{$_delivery or ''}}"><a href="{{route('add.stock')}}"><i><img src="{{asset('homestyle/images/jiang-6.png')}}"></i> <span>交割单</span></a></li>
        </ul>
    </div>
</div>