@extends('mobile.layout.app')
      @section('content')
<!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px;">
    <form method="get" action="{{route('mobile.search')}}">
        <div style="height:40px;" class="">
            <div class="input-group menu"> <span class="input-group-addon">
      <button type="button" class="sesrch-btn search"><img src="homestyle/m_img/search.png" class="img-responsive"></button>
      </span>
                <input name="name" type="text" class="search-text">
            </div>
        </div>
        <input type="submit" class="mobile_search" style="display:none;" />
    </form>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div style="margin-top:50px;">
    <div id="myCarousel" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active" style="background:#7481fa;"> <img src="homestyle/m_img/banner.jpg" alt="第一张"> </div>
            <div class="item" style="background:#7481fa;"> <img src="homestyle/m_img/banner.jpg" alt="第二张"> </div>
            <div class="item" style="background:#7481fa;"> <img src="homestyle/m_img/banner.jpg" alt="第三张"> </div>
        </div>
    </div>
</div>
<div>
    <ul class="list-unstyled line">
        @foreach($live_message as $l)
            @if(!empty($l->user))
        <li style="margin-top: 0px; ">
            <div class="row">
                <div class="col-xs-2">
                   <div class="txt"><img src="homestyle/m_img/notice.png"> 预告</div>
                </div>
                <div class="col-xs-7">
                    <p class="text-left" style="white-space: nowrap; overflow: hidden;">{{$l->title}}</p>
                    <p class="text-left" style="font-size:0.8em; color:#999;">{{$l->start_time}}</p>
                </div>
                <div class="col-xs-3">
                    <a  style="margin-top:5px; display: inline-block;" href="{{route('mobile.live',[$l->user_id,$l->user->lecturer->room->streams_name])}}">查看</a>
                </div>
            </div>
           
        </li>
            @endif
            @endforeach
    </ul>
</div>
<div class="hot">
    <div class="title">
        <h2 class="tab-h2">热门推荐</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="title">
                <ul class="tec">
                    @foreach($lives as $l)
                        @if(!empty($l->user))
                            @if(!empty($l->room))
                    <li>
                        <a href="{{route('mobile.live',[$l->user_id,$l->room->streams_name])}}">
                            <div class="r-img">
                                @if(empty($l->room->thumb))
                                <img src="/homestyle/images/p1.png" class="img-responsive">
                                @else
                                    <img src="{{$l->room->thumb}}" class="img-responsive">
                                    @endif
                                    @if(empty(liveStatus($l->room->streams_name)['status']))
                                        <div class="living"><span style="color:#26B406;">●</span><span style="color:#fff;">直播中</span></div>
                                        @else
                                        <div class="living"><span style="color:#ff4f38;">●</span><span style="color:#fff;">暂未开播</span></div>
                                    @endif

                                <div class="tec-name">
                                    <span class="pull-left">
                                        @if(empty($l->user->name))
                                            {{$l->user->oauth->nickname}}
                                            @else
                                            {{$l->user->name}}
                                            @endif
                                    </span>
                                    <span class="pull-right"><i class="name-icon"><img src="homestyle/m_img/people.png" class="img-responsive"></i>{{App\Models\Follow::where('user_id',$l->user_id)->count()}}</span>
                                </div>
                            </div>
                            <p >{{$l->room->room_name}}</p>
                        </a>
                    </li>
                            @endif
                        @endif
                        @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
<div class="hot">
    <div class="title">
        <h2 class="tab-h2">正在直播</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="title">
                <ul class="tec">
                    @foreach($living as $live)
                            <li>
                                    <a href="{{route('mobile.live',[$live->lecturer->user_id,$live->streams_name])}}">
                                        <div class="r-img">
                                            <img src="{{photoUrl($live->streams_name)}}" class="img-responsive">
                                            <div class="living"><span style="color:#26B406;">●</span><span style="color:#fff;">直播中</span></div>
                                            <div class="tec-name">
                                    <span class="pull-left">
                                        @if(empty($live->lecturer->user))
                                            {{$live->lecturer->user->oauth->nickname}}
                                        @else
                                            {{$live->lecturer->user->name}}
                                        @endif
                                    </span>
                                                <span class="pull-right"><i class="name-icon">
                                                        <img src="homestyle/m_img/people.png" class="img-responsive">
                                                    </i>{{App\Models\Follow::where('user_id',$live->lecturer->user_id)->count()}}</span>
                                            </div>
                                        </div>
                                        <p >{{$live->room_name}}</p>
                                    </a>
                                </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
<!--主界面内容end-->
<!--底部固定导航-->
<div style="height:50px;"></div>
@include('mobile.layout.footer')
<!--底部固定导航end-->
@stop
@section('js')
    <script>
        $(function(){
            document.onkeydown = function(e){
                var ev = document.all ? window.event : e;
                if(ev.keyCode==13) {
                    var name = $('input[name=name]').val();
                    if(name == ''){
                        layer.open({
                            content: '搜索内容不能为空！'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                        return false;
                    }
                    $('.mobile_search').click();
                }
            }
        })
    </script>
    @stop