<div class="usercenter">
    <div class="userbg">
        <a href="{{route('user')}}">
            <div class="userimg">
                @if(!empty($userinfo->thumb))
                    <img src="{{$userinfo->thumb}}" class="left_thumb img-circle" width="127" height="127">
                @elseif(!is_null($userinfo->oauth))
                    <img class="img-circle" src="{{$userinfo->oauth->avatar_url}}" width="127" height="127">
                @endif
            </div>
        </a>
        <div class="clear"></div>
        <div class="username">
            @if(empty($userinfo->name))
                <p class="centername">{{$userinfo->oauth->nickname}}</p>
                @else
                <p class="centername">{{$userinfo->name}}</p>
                @endif
                @if(!empty($userinfo->phone))
            <p>手机号码：{{$userinfo->phone}}</p>
                @else
                    <p>手机号码：未认证</p>
                    @endif
            <p class="chongzhi"><span><i></i>{{$userinfo->gold}}</span>
                    <span class="czbtn">
                                    <a href="{{route('pay.type')}}">充值</a>
                                </span>
            </p>
        </div>
        <div class="clear"></div>
        <div class="guanzhu">
            <ul>
                <li><a href="{{route('follow')}}">
                        <p style="font-size:16px; font-weight:600;">{{App\Models\Follow::where('my_id',$userinfo->id)->count()}}</p>
                        <p>关注</p>
                    </a></li>
                <li style=" border-left:1px #ddd solid;"><a href="{{route('fans')}}">
                        <p style="font-size:16px; font-weight:600;">{{App\Models\Follow::where('user_id',$userinfo->id)->count()}}</p>
                        <p>粉丝</p>
                    </a></li>
            </ul>
        </div>
    </div>
</div>