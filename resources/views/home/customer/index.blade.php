@extends('home.layout.app')

@section('content')
    <div class="container user">
        <div class="row">
            <!--左侧-->
            <div class="pull-left userleft">
                <div class="usercenter">
                    <div class="userbg">
                        <div class="userimg">
                            @if(!empty($customer->thumb))
                            <img src="{{$customer->thumb}}" class="left_thumb img-circle" width="127" height="127">
                            @else
                            <img class="img-circle" src="{{$customer->oauth->avatar_url}}" width="127" height="127">
                            @endif
                        </div>
                        <div class="clear"></div>
                        <div class="username">
                            @if(empty($customer->name))
                            <p class="centername">{{$customer->oauth->nickname}}</p>
                            @else
                            <p class="centername">{{$customer->name}}</p>
                            @endif
                        </div>
                        <div class="guanzhu">
                            <ul>
                                <li><a href="">
                                <p style="font-size:16px; font-weight:600;">{{App\Models\Follow::where('my_id',$customer->id)->count()}}</p>
                                <p>关注</p>
                                </a></li>
                                <li style=" border-left:1px #ddd solid;"><a href="">
                                <p style="font-size:16px; font-weight:600;">{{App\Models\Follow::where('user_id',$customer->id)->count()}}</p>
                                <p>粉丝</p>
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="menulist">
                    <ul>
                        <li class="{{$_live or ''}}"><a href="{{route('customer.live',$customer->id)}}"><i><img src="{{asset('homestyle/images/userimg4.png')}}"></i> 直播记录</a></li>
                        <li class="{{$_customer or ''}}"><a href="{{route('customer.article',$customer->id)}}"><i><img src="{{asset('homestyle/images/userimg2.png')}}"></i> 他的文章</a></li>
                        <li class="{{$_view or ''}}"><a href="{{route('customer.view',$customer->id)}}"><i><img src="{{asset('/homestyle/images/jiang-3.png')}}"></i> 他的观点</a></li>

                    </ul>
                </div>
            </div>
                    <!--左侧结束-->
            <!--右侧-->
            <div class="pull-right userright">
                <div class="record">
                    <div class="recording">
                        <div style=" width:100%; height:50px;border-bottom:#ddd 1px solid;">
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>文章列表</div>
                        </div>
                        <div class="clear"></div>
                        <div class="tab-content">

                            <div class="message-1">
                                @if($articles->isEmpty())
                                <div class="rightcon">
                                    <div class="collapse" >
                                        <div class="well text-success">
                                            暂未发表文章！
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <ul>
                                    @foreach($articles as $article)
                                        <li>
                                            <a href="{{route('details',$article->id)}}" target="_blank">
                                                <div class="pull-left m-left">
                                                    <div class="mymessage"> <img src="{{$article->user->thumb}}" width="60" height="60"></div>
                                                    <div class="mytxt">
                                                        <div class="release-1">
                                                            <h4>{{$article->title}}</h4>
                                                            <div class="re-person">发布者：<span>{{$article->user->name}}</span></div>
                                                            <div class="re-txt">
                                                                <p>{!! subtext($article->contents,60) !!}</p>
                                                            </div>
                                                            <div class="re-txt" style="height:40px;">
                                                                <div class="pull-left"><i class="glyphicon glyphicon-time"></i> {{$article->ctime}}</div>
                                                                <div class="pull-right read">
                                                                    <span>阅读：<strong>{{$article->count}}人</strong></span>
                                                                    <span>评论：<strong>{{$article->comments->count()}}条</strong></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pull-right m-right"><img src="{{$article->img}}" width="152" height="102"></div>
                                            </a>

                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:5px;"></div>
                <div aria-label="Page navigation">
                    <ul class="pagination">
                        {!! $articles->links() !!}
                    </ul>
                </div>
            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
