<!--左侧-->
<div class="pull-left userleft">
   @include('home.user.user_content')
    <div class="menulist">
        <ul>
            <li class="{{$_user or ''}}"><a href="{{route('user')}}"><i><img src="{{asset('homestyle/images/userimg1.png')}}"></i> 我的资料</a></li>
            <li class="{{$_pay or ''}}"><a href="{{route('pay.record')}}"><i><img src="{{asset('homestyle/images/userimg2.png')}}"></i> 交易记录</a></li>
            <li class="{{$_following or ''}}"><a href="{{route('follow')}}"><i><img src="{{asset('homestyle/images/userimg3.png')}}"></i> 我的关注</a></li>
            <li class="{{$_fans or ''}}"><a href="{{route('fans')}}"><i><img src="{{asset('homestyle/images/userimg3.png')}}"></i> 我的粉丝</a></li>
            <li class="{{$_message or ''}}"><a href="{{route('user.message')}}"><i><img src="{{asset('homestyle/images/userimg4.png')}}"></i> 我的消息</a></li>
            <li class="{{$_promotion or ''}}"><a href="{{route('promotion')}}"><i><img src="{{asset('homestyle/images/jiang-4.png')}}"></i> 推广中心</a></li>
            <li class="{{$_drawal or ''}}"><a href="{{route('withdrawals_index')}}"><i><img src="{{asset('homestyle/images/jiang-5.png')}}"></i> 资产管理</a></li>

            @if(empty($lec)||$lec->status==1)
                <li>
                    <a href="{{route('apply_lecturer_get')}}">
                        <i><img src="{{asset('homestyle/images/userimg5.png')}}"></i> 申请讲师
                    </a>
                </li>
            @elseif(!empty($lec)&&$lec->status==2)
                <li>
                    <a href="{{route('lecturer_index')}}">
                        <i><img src="{{asset('homestyle/images/userimg5.png')}}"></i> 讲师中心
                    </a>
                </li>
                @else
                <li>
                    <a href="{{route('apply_lecturer_edit')}}">
                        <i><img src="{{asset('homestyle/images/userimg5.png')}}"></i> 申请讲师
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
<!--左侧结束-->