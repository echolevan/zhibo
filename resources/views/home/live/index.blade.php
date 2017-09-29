@extends('home.layout.app')
@section('css')
    <link rel="stylesheet" href="{{asset('/homestyle/css/studio-505d76e986.css')}}" type="text/css">
    <link type="text/css" rel="stylesheet" href="{{asset('/homestyle/css/headline.css')}}">
    <link rel="stylesheet" href="{{asset('/homestyle/css/headfoot-7232928f5d.mix.css')}}" type="text/css">
    <link href="{{asset('video/video-js.css')}}" rel="stylesheet">
    <!-- If you'd like to support IE8 -->
    <script src="{{asset('video/videojs-ie8.min.js')}}"></script>

    <!--is face-->
    <link rel="stylesheet" href="{{asset('/homestyle/face/jquery.sinaEmotion.css')}}" type="text/css">

    <script type="text/javascript">
        $(function(){
            $(".line").slideUp();
        })
    </script>

    <!--is barrage-->
    <link rel="stylesheet" href="{{asset('/dist/css/barrager.css')}}" type="text/css">

	<link rel="stylesheet" href="{{asset('/homestyle/css/live_new.css')}}" id="layuicss-skinlayercss" />
    <script>
        $(function () {
            var log = function(s){
                window.console && console.log(s)
            }
            $('.nav-tabs a:first').tab('show')
            $('a[data-toggle="tab"]').on('show', function (e) {
                log(e)
            })
            $('a[data-toggle="tab"]').on('shown', function (e) {
                log(e.target) // activated tab
                log(e.relatedTarget) // previous tab
            })
        })
    </script>
    <style>
        .vjs-default-skin.vjs-big-play-centered .vjs-big-play-button {
            /* Center it horizontally */
            left: 50%;
            margin-left: -2.1em;
            /* Center it vertically */
            top: 50%;
            margin-top: -1.4000000000000001em;
        }
    </style>
    @stop
 
@section('content')
    <input type="hidden" value="{{$room->id}}" name="room_id"/>
    <div class="wrapper" id="liveWrapper">
        <div class="video-wrap" id="div_frame_main">
            <div class="w-liveplayer">
			
				<!-- left -->
				<div  class="live_left_side">
					<div class="login-zone">
						<!--
						<div class="slider-nav-logo">
							<a href="" target="_blank"></a>
						</div>
						-->
						<div class="slider-nav-userinfo-item">
						@if (Auth::guest())
							<div class="unlogin-item">
								<span class="slider-nav-unlogin-btn">登录</span>
							</div>
						@else
							<div class="user_center_info">	
								<a href="{{route('user')}}">
									<span class="pull-left">
									@if(empty($userinfo->oauth))
										@if(empty($userinfo->thumb))
											<img class="img-circle" src="/homestyle/images/admin.png" width="60" height="60">
										@else
											<img class="img-circle" src="{{$userinfo->thumb}}" width="60" height="60">
										@endif
									@else
										<img class="img-circle" src="{{$userinfo->oauth->avatar_url}}" width="60" height="60">
									@endif
									</span>
								</a>	
							</div>
						@endif	
						</div>
					</div>
				
					<div class="login-zone side_title Marketindex">
					<h2>行情指数</h2>
					<iframe marginwidth="0" marginheight="0" src="http://data.stock.hexun.com/quotes/stock_1.htm" scrolling="no" frameborder="0" height="250" width="100%"></iframe>
					</div>
				
					<div class="login-zone side_title Marketdata">
					<h2>行情数据</h2>
					<iframe marginwidth="0" marginheight="0" src="http://www.feinongdata.com/jiekou/" frameborder="0" height="628" width="100%"></iframe>
					</div>
				
				
				</div>			
			
			
			
				<!-- middle -->
                <div id="wLiveplayer" class="w-liveplayer-main w-liveplayer-type-xiu w-liveplayer-noanchor-norotate w-liveplayer-ready">
                    <div id="playerMain" class="w-liveplayer-video">
                        <div style=" width:100%; height:100%; display:block;position:absolute; left:0%; top:0%;">
                            @if(empty(liveStatus($room->streams_name)['status']))
                                <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" style="width:100%; height:100%; display:block;"
                                       poster="{{photoUrl($room->streams_name)}}"
                                       data-setup="{}">
                                    <source src="{{playUrl($room->streams_name)}}" type="rtmp/flv">
                                    <source src="{{hlsUrl($room->streams_name)}}" type='application/x-mpegURL'>
                                </video>
                                @else
                                <div style=" width:80%; margin:auto; display: block;">
                                    <p style="text-align:center; font-size:30px; color:#fff; line-height:50px; position:relative; top:100px;">主播暂未开播，看看ta的<span style="color:#ff6412;">直播录像</span>吧!</p>
                                    <p style="width:100%; margin:auto;background:url(/homestyle/images/line-1.png) center no-repeat; height:50px;line-height:50px;text-align:center;position:relative; top:180px; color:#fff; font-size:18px;"> 直播推荐 </p>
                                    <div class="biglive" style="position:relative; top:200px;">
                                        <ul>
                                            @foreach($history as $h_l)
                                            <li> <a href="{{route('back.live.details',$h_l->id)}}">
                                                    <div class="liveimg"> <img src="http://{{$h_l->thumb}}" width="224" height="121"> </div>
                                                    <div class="livetxt">
                                                        <p  class="livetit">{{$h_l->title}}</p>
                                                        <p  class="livetec">
                                                            @if(empty($h_l->user->name))
                                                                <span class="pull-left">讲师：{{$h_l->user->oauth->nickname}}</span>
                                                                @else
                                                                <span class="pull-left">讲师：{{$h_l->user->name}}</span>
                                                                @endif
                                                            <span class="pull-right text-right" style="color:#de4c44;">
                                                                <i class="glyphicon  glyphicon-heart" style="top:3px;"></i>{{$h_l->count}}</span> </p>
                                                    </div>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                        </div>
                    </div>
                    <!-- + 礼物区-->
                    <div class="w-liveplayer-present" style="margin-top:10px">
					<img src="/homestyle/images/ad_gift.jpg" width="100%"/>
                        <style type="text/css">
                            .task-wrap {
                                width: 501px!important;
                                height: 80px!important;
                            }
                        </style>
                        <div class="ent-content">

                            <!--礼物栏
                            <div class="module-box toolbar" id="wLiveplayerBottom">
                                <div class="gift-submit" id="gift-select-list-id">
                                    <form class="form">
                                        <div class="button" id="sendGiftBtn">
                                            <div class="combo-animation" id="combo_hit_animation">
                                                <div class="effect-frames"></div>
                                                <div class="left-time" id="combo_hit_left_time"></div>
                                            </div>
                                            <button class="give" type="button"></button>
                                        </div>
                                        <div class="result" id="gift-select-img-id">
                                            <input name="gift" type="text" pattern="\d+" class="num-input" id="giftInputNum" value="1" maxlength="5">
                                        </div>
                                    </form>
                                   
                                    <div class="charge" id="gift-recharge-btn"><a href="{{route('pay.type')}}" target="_blank" title="充值"><i class="icon"></i><br>
                                            <span>充值</span></a></div>
                                </div>
                                <div class="gift-list" id="gift-list-id">
                                    <div class="tabs"><a href="#" title="礼物" class="icon active" id="paidGifts">礼物</a> </div>
                                    <div class="gifts active">
                                        <div class="gifts-wrap">
                                            <ul id="paid-gifts-wrap">
                                                <?php $s = 1 ?>
                                                @foreach($gifs as $g)
                                                <li data-id="{{$g->id}}" data-img="{{$g->img}}" id="gift_{{$g->id}}"  source="{{$g->gif}}"><a href="javascript:void (0);"> <img  id="giftImg{{$s++}}" src="{{$g->img}}"> </a></li>
                                                @endforeach

                                            </ul>
                                        </div>
                                        <div class="tips-list" id="paid-tips-list">
                                            <?php $i = 1;$s = 0 ?>
                                            @foreach($gifs as $g)
                                            <div class="tips{{$i++}}" style="left: {{($s++)*58+3}}px; bottom: 55px;">
                                                <div class="tips-content">
                                                    <div class="intro">
                                                        <div class="left"><img src="{{$g->gif}}"></div>
                                                        <div class="right">
                                                            <div class="title">{{$g->name}}<span class="price">({{$g->price}})金币</span></div>
                                                            <div class="desc">{{$g->description}}</div>
                                                            {{--<div class="combo">一次赠送 <strong>66</strong> 个即可触发1星流光</div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="more"></div>
                                                <div class="tips-bg"></div>
                                                <div class="tips-bg bot"></div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="buttons">
                                </div>
                            </div>
							-->
                        </div>
                    </div>
					
					
					
				<!-- 文章区 -->
				<div class="article_comment">
					<div class="type-tab js-stats-area">   
						<a class="user-index js-stats-click on">文章</a>  
						<a class="user-index js-stats-click">观点</a>
						<a class="user-video js-stats-click" >视频回看</a>
						<a class="user-video js-stats-click" >付费提问</a>
					</div>
					
					<div class="article_body">
						<ul class="status-list" style="display: block;">
						@foreach($articles as $article)						
							<li class="js-stats-click" >
								<div class="feed-item single-item">
									<div class="feed-main">
										<div class="feed-hd">
											<div class="feed-name-wrap">
												<span class="feed-time">{{$article->ctime}}</span>
												
												<span class="feed-type-tip">发布了一篇文章</span>
												
											</div>
										</div>
										<div class="feed-bd">
											<div class="feed-summary">
												<h2 class="feed-title">
													
														<a target="_blank" href="{{route('details',$article->id)}}">
															{{$article->title}}
														</a>													
												</h2>
												<div class="summary-content">
													<?php echo strip_tags(subtext($article->contents,140))?>
													<a class="toggle-expand" target="_blank" href="{{route('details',$article->id)}}" title="查看全文">查看全文</a>
												</div>

											</div>
										</div>
										<div class="feed-ft">
											<div class="feed-btn">
												
													
													<a target="_blank" href="javascript:void(0)" class="feed-like ">阅读({{$article->count}})</a>
													<span class="split-line">|</span>
													<a target="_blank" href="javascript:void(0)" class="btn-feed-comment">评论({{$article->comments->count()}})</a>
												
											</div>
										</div>
									</div>
								</div>
							</li>
						@endforeach		
						</ul>

                        <ul class="status-list">
                            @foreach($viewpoints as $viewpoint)
                                <li class="js-stats-click" >
                                    <div class="feed-item single-item">
                                        <div class="feed-main">
                                            <div class="feed-hd">
                                                <div class="feed-name-wrap">
                                                    <span class="feed-time">{{$viewpoint->ctime}}</span>

                                                    <span class="feed-type-tip">发布了一篇观点</span>

                                                </div>
                                            </div>
                                            <div class="feed-bd">
                                                <div class="feed-summary">
                                                    <h2 class="feed-title">

                                                        <a target="_blank" href="{{route('details',$viewpoint->id)}}">
                                                            {{$viewpoint->title}}
                                                        </a>
                                                    </h2>
                                                    <div class="summary-content">
                                                        <?php echo strip_tags(subtext($viewpoint->contents,140))?>
                                                        <a class="toggle-expand" target="_blank" href="{{route('details',$viewpoint->id)}}" title="查看全文">查看全文</a>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="feed-ft">
                                                <div class="feed-btn">


                                                    <a target="_blank" href="javascript:void(0)" class="feed-like ">阅读({{$viewpoint->count}})</a>
                                                    <span class="split-line">|</span>
                                                    <a target="_blank" href="javascript:void(0)" class="btn-feed-comment">评论({{$viewpoint->comments->count()}})</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

						<ul class="status-list history_video_list">
						@foreach($history as $h_l)
							<li>
								<div class="video_history_item">
									<div class="feed-hd">
										<div class="feed-name-wrap">
											<span class="feed-time">{{$h_l->created_time}}</span>
											<span class="feed-type-tip">发布了一个视频</span>
										</div>
									</div>
									<div class="feed-bg-video">										
										<a class="video-title" href="{{route('back.live.details',$h_l->id)}}" target="_blank">
											{{$h_l->title}}
										</a>								
										<div class="video-body">
											<a href="{{route('back.live.details',$h_l->id)}}" target="_blank">
											<div class="video-info-wrap js-video-item">
												<img class="replacesrc cover" src="http://{{$h_l->thumb}}" width="350" height="170" style="border: 1px solid #ccc">
											</div>
											</a>
										</div>
									</div>
								</div>								
							</li>
							@endforeach
							
						</ul>

                        <ul class="status-list">
                            @foreach($reply_msg as $msg)
                                <li class="js-stats-click" >
                                    <div class="feed-item single-item">
                                        <div class="feed-main">
                                            <div class="feed-hd">
                                                <div class="feed-name-wrap">
                                                    <span class="feed-time">{{$msg->created_time}}</span>

                                                 {{--   <span class="feed-type-tip">发布了一篇观点</span>--}}
                                                </div>
                                            </div>
                                            <div class="feed-bd">
                                                <div class="feed-summary">
                                                    <h2 class="feed-title">

                                                    {{--<a target="_blank" href="{{route('details',$viewpoint->id)}}">--}}
                                                            {{$msg->title}}
                                                        <!--</a>-->
                                                    </h2>
                                                    <div class="summary-content">
                                                        <?php echo strip_tags(subtext($msg->reply,140))?>
                                                            {{--<a class="toggle-expand" target="_blank" href="{{route('$msg',$msg->id)}}" title="查看全文">查看全文</a>---}}
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="feed-ft">
                                                <div class="feed-btn">


                                {{--<a target="_blank" href="javascript:void(0)" class="feed-like ">阅读({{reply->count}})</a>
                                <span class="split-line">|</span>
                                <a target="_blank" href="javascript:void(0)" class="btn-feed-comment">评论({{reply->comments->count()}})</a>---}}

                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
</div>

<script type="text/javascript">
$(".js-stats-area a").each(function(index){
    $(this).mouseover(function(){
        $(this).addClass('on').siblings().removeClass('on');
        $(".status-list").css("display","none").eq(index).css("display","block");
    });
});
</script>







</div>



<!-- right -->
<div class="w-liveplayer-side" id="div_frame_right">
<!-- + 用户信息区-->
<div id="wLiveplayerUserInfo" class="w-liveplayer-userinfo w-liveplayer-userinfo-hastags">
    <a href="{{route('customer.live',$lecturer->user_id)}}" target="_blank" class="cover">
        <span class="w-liveplayer-sprite"></span>
        @if(empty($lecturer->user->oauth))
            @if(empty($lecturer->user->thumb))
                <img src="{{asset('homestyle/images/admin.png')}}" alt="{{$lecturer->user->name}}" width="58" height="58">
                @else
                <img src="{{$lecturer->user->thumb}}" alt="{{$lecturer->user->name}}" width="58" height="58">
                @endif
            @else
            <img src="{{$lecturer->user->oauth->avatar_url}}" alt="{{$lecturer->user->name}}" width="58" height="58">
        @endif
        <img src="/homestyle/imgs/v-type16-1.png" class="v-type16"></a>
    <div class="basic">
        <div id="cherishIcon" class="icon-identity" style="display: block;">
            <img class="icon-cherish" src="/homestyle/imgs/1.png" width="16" height="15" alt="">
        </div>
        <a href="{{route('customer.live',$lecturer->user_id)}}" target="_blank" class="name">
            @if(empty($lecturer->user->name))
                {{$lecturer->user->oauth->nickname}}
                @else
                {{$lecturer->user->name}}
                @endif
        </a> </div>
    <div class="intro" style="display: block;">人气:
        <span id="onlineCount" class="num"></span>
    </div>
    <a href="javascript:;" class="w-liveplayer-followbtn">
        @if (\Auth::check())
            @if($userinfo->id != $lecturer->user_id)
           @if(empty(\App\Models\Follow::where('my_id',$userinfo->id)->where('user_id',$lecturer->user_id)->first()))
            <span class="s1 follow" data-id="{{$lecturer->user_id}}">关注</span>
               @else
                <span class="s1 unfollow" data-id="{{$lecturer->user_id}}">取消关注</span>
               @endif
                @endif
            @else
            <span class="follow">关注</span>
        @endif
    </a>
</div>
<!-- - 用户信息区-->
<!-- + 选项卡区域-->
<div id="wLiveplayerBangArea" class="w-liveplayer-tabArea">
    <div class="ent-content">
        <ul class="nav nav-tabs gifts-tab" id="myTab">
            <li class=""><a href="#home" data-toggle="tab">付费提问</a></li>
            <li><a href="#profile" data-toggle="tab">礼物月榜</a></li>
            {{--<li><a href="#messages" data-toggle="tab">在线用户</a></li>--}}
                            </ul>
                            <div class="clear"></div>
                            <div class="tab-content">
                                <div class="tab-pane" id="home">
                                    <ul class="questionBox">
<!--                                        <li>
                                            <a href="javascript:void (0);">
                                                <i>
                                                    <img src="/homestyle/images/w.png" width="20" height="20">
                                                </i>
                                                <span></span>
                                                <span style="color:#ff4436;">
                                                    <img src="/homestyle/images/gold.png" width="12" height="14">￥
                                                </span>
                                            </a>
                                        </li>-->
                                    </ul>
                                </div>
                                <div class="tab-pane contribution-list" id="profile">
                                    <ul>
                                        <?php $i = 1 ?>
                                        @foreach($GifTop as $t)
                                        <li>
                                            <div class="info">
                                                <div class="fortune">
                                                    <span style="color:#ff4436;">
                                                    <img src="/homestyle/images/gold.png" width="12" height="14">￥
                                                </span>
                                                    {{$t->sum_price}}
                                                </div>
                                            </div>
                                            <div class="user">
                                                <i class="order order-1">{{$i++}}</i>
                                                <span class="nick ellipsis">
                                                    <a href="">{{$t->send_name}}</a>
                                                </span>
                                            </div>
                                        </li>
                                            @endforeach
                                    </ul>
                                </div>
                                {{--<div class="tab-pane" id="messages">
                                    <ul>
                                        <li class="off">
                                            <a href="">
                                                <span class="pull-left">000999这只股，几天走势如何？</span>
                                                <span class="pull-right"><button type="button" class="forbidden">禁言</button></span>
                                            </a>
                                        </li>
                                        <div class="clear"></div>
                                    </ul>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                    <!-- - 选项卡区域-->
                    <!--公告区域-->
                    <div class="bulletin">
                        <p><i class="gg"><img src="/homestyle/images/gg.png" width="22" height="20"></i>直播公告：</p>
                        <ul class="line">
                            <li style="margin-top: 0px; "> 欢迎进入直播室！ </li>
                        </ul>
                    </div>
                    <!--公告区域end-->
                    <!-- + 公屏区域-->
                    <div id="wLiveplayerGongpin" class="w-liveplayer-gongpin">
                        <div class="chatroom-wrapper">
                            <div class="chat-room">
                                <div class="chat-room-bd">
                                    <div class="scroll-sidebar-cont">
                                        <div class="scroll-cont-inner">
                                            <ul class="chatroom-list chatInfo">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tips-chat">
                                <div class="chat-room-ft">
                                    <div class=" expression">
                                        <button type="button" id="face"><img src="/homestyle/images/bq.png" width="23" height="24"></button>
                                        <button type="button" id="barrage" tipsNum="0" data-toggle="tooltip" data-placement="right" title="Tooltip on right"><img src="{{$room->barrage == 1?'/homestyle/images/barrageon.png':'/homestyle/images/barrageoff.png'}}" width="23" height="24"></button>
                                    </div>
                                    <!-- + 用户输入框-->
                                    <div class="chat-room-input">
                                        <textarea id="msgInput" name="" rows="2" placeholder="快跟ta互动吧" class="msg-input msg"></textarea>
                                        <span class="msg-input-num">1/30</span>
                                    </div>
                                    <div style="float:right; margin-right:20px;">
                                        <div class="checkbox pull-right">
                                            <label class="btn-success questions">
                                                <i class="input_style"><span class="glyphicon glyphicon-gbp" aria-hidden="true"></span></i>
                                                发表付费提问&nbsp;
                                            </label>
                                            <button type="" id="btnCommit" class="checkbox-btn"><img src="/homestyle/images/sengimg.png"> 发送</button>

                                        </div>
                                    </div>
                                    <!-- — 用户输入框-->
                                    <!-- + 提示浮层-->
                                    <div class="chat-input-tips">
                                        <div class="pop-arrow">
                                            <div class="arrow-1"></div>
                                            <div class="arrow-2"></div>
                                        </div>
                                        <p class="tips"> </p>
                                    </div>
                                    <!-- - 提示浮层-->
                                </div>
                            </div>
                            <input type="hidden" id="barrage_system" value="{{$room->barrage}}" >
                            <input type="hidden" id="barrage_default" value="1">
                            <input type="hidden" id="speak" value="{{$room->speak}}">
                        </div>
                    </div>
                    
					
					<div class="zhubo_info">
						<h2>房间简介</h2>
						<p>
						{{$room->desc}}
						</p>
					</div>					
					
                </div>
                <!-- - 侧栏-->

            </div>
        </div>
    </div>
    <span id="userData" userData='{{$userData}}' question="{{$messages}}"> </span>
        <div class="login_form" id="questions" style="width:290px;height:250px;margin-left:30px; display: none;">
            <form>
                <div class="logininput">
                    <input type="text" name="reply_price" class="form-control" placeholder="提问金额" />
                    <br>
                    <textarea class="form-control" placeholder="请输入问题！！！" id="title"></textarea>
                </div>
                <div class="loginbtn">
                    <div class="loginsubmit fl">
                        <button type="button" class="reply">提问</button>
                        <div class="loginsubmiting">
                            <div class="loginsubmiting_inner"> </div>
                        </div>
                    </div>
                    <div class="clear"> </div>
                </div>
            </form>
        </div>
    @stop
 


@section('js')
    <script src="{{asset('/homestyle/face/jquery.sinaEmotion.js')}}"></script>
    <script src="{{asset('video/video.js')}}"></script>
   <script src="{{asset('/homestyle/js/live.js')}}"></script>
    <script src="{{asset('/homestyle/js/bootstrap-tab.js')}}"></script>
    <script src="{{asset('/homestyle/js/swfobject.js')}}"></script>
    <script src="{{asset('/homestyle/js/web_socket.js')}}"></script>
    <script type="text/javascript">
        var myPlayer = videojs('my-video');
        videojs("my-video").ready(function(){
            var myPlayer = this;
            myPlayer.play();
        });
    </script>
<script>
    $(function(){
 
		$(".slider-nav-unlogin-btn").click(function(){
			$('#login-modal').show();
		});

 
		@if (Auth::guest())
		setInterval(function(){
			$('#login-modal').show();
		},300000)
		@endif
		
		
		$(".close").click(function(){
			$('#login-modal').hide();
		});		
		
		live_left_side = $('.live_left_side').width();
		div_frame_right = $('#div_frame_right').width();
		$('#wLiveplayer').css('width', $('.video-wrap').width()-live_left_side-div_frame_right-2);
		console.log(live_left_side);
        //$('#div_frame_body').css("overflow", "hidden");

        
        //模块尺寸
        //$('#div_frame_body').css('height', $(window).height());
        //$('#div_frame_main').css('height', $(window).height() - 100);
//        $('#div_frame_left').css('height', $(window).height() - 130);
        //$('#wLiveplayer').css('height', $(window).height() - 130);
        //$('#div_frame_right').css('height', $(window).height() - 130);
        //$('#playerMain').css('height', $(window).height()- 204);

        $(window).resize(function() {
            //模块尺寸
           //$('#div_frame_body').css('height', $(window).height());
           // $('#div_frame_main').css('height', $(window).height() - 100);
//            $('#div_frame_left').css('height', $(window).height() - 130);
           // $('#wLiveplayer').css('height', $(window).height() - 130);
           // $('#div_frame_right').css('height', $(window).height() - 130);
            //$('#playerMain').css('height', $(window).height() - 204);

        });
        //$('#div_frame_body').css('height', $(window).height());//使用juqery函数获取浏览器窗体的高度，后面减去的是已经占用的具体高度

        
        
        $("#barrage").bind("click",function() {
            
            var barrage_default = $("#barrage_default").val();
            if(barrage_default == 1){
                $("#barrage_default").val(2);
                $("#barrage").html('<img src="/homestyle/images/barrageoff.png" width="23" height="24">');
                $.fn.barrager.removeAll();
            }
            if(barrage_default == 2){
                $("#barrage_default").val(1);
                $("#barrage").html('<img src="/homestyle/images/barrageon.png" width="23" height="24">');
            }
        });
        
        $("#barrage").bind("mouseover", function(){
        var isShow =  parseInt($(this).attr("tipsNum")) < 1 ? true : false;
//        var tips =  $("#barrage_default").val() == 1 ? "关闭弹幕" : "打开弹幕";
        if (isShow){
            var tips =  "弹幕设置";
            layer.tips(tips, "#barrage");
            $(this).attr("tipsNum", 1);
        }
            
        });
        
    })

	
	
	

    $('#face').SinaEmotion($('#msgInput'));
    $(function () {
        $('#paid-gifts-wrap li').click(function(){
            $('#paid-gifts-wrap li').removeClass('active');
            $(this).addClass('active');
            $('.gift').remove();
            var gift_id = $(this).data('id');
            var img = $(this).data('img');
            var gif = '<img class="gift" data-id="'+gift_id+'" src="'+img+'">';
            $(gif).appendTo('#gift-select-img-id');

        });

        $('.questions').click(function(){
            layer.open({
                type: 1,
                anim: 2,
                title:'付费提问',
                area: ['350px','320px'],
                shade: 0.5,
                time:60000, // 自动关闭
                closeBtn: 1, //不显示关闭按钮
                shadeClose: true, //开启遮罩关闭
                 id: 'rt',
                Boolean: true,
                content: $('#questions'),
            });
        })

        $('.reply').click(function(){
            @if (\Auth::check())

            var reply_price = $('input[name=reply_price]').val();
            var title = $('#title').val();
            if(reply_price == ''){
                layer.msg('请填输入金额！');
                return false;
            }
            if(reply_price < 1){
                layer.msg('金额不能小于一金币！');
                return false;
            }
            if(title == ''){
                layer.msg('请填写问题！');
                return false;
            }
            var data = {
                to_user_id: '{{$lecturer->user->id}}',
                title: title,
                reply_price: reply_price
            }
            $.ajax({
                type: 'post',
                url: '{{route('user.question')}}',
                data: data,
                success: function(data){
                    if(data.status == false){
                        layer.msg(data.msg,{icon: 5});
                        return false;
                    }
                    layer.msg(data.msg,{icon: 1});
                    setTimeout(function () {
                        parent.layer.closeAll();
                    }, 600);
                    return false;
                },error: function(){

                    layer.msg('操作失败！',{icon: 5});
                    return false;
                }
            });
            @else
          layer.msg('请先登录！',{icon: 5});
            @endif
        })


        $('.give').click(function(){
            @if (\Auth::check())
            var number = $('input[name=gift]').val();
            var gift_id = $('.gift').data('id');
            if(gift_id == null){
                layer.msg('请选择礼物！',{icon: 5});
                return false;
            }
            var data = {
                number: number,
                gift_id: gift_id,
                user_id: '{{$lecturer->user_id}}'
            };
            $.ajax({
                type:'post',
                url: '{{url('live/present')}}',
                data: data,
                success: function(data){
                    if(data.status == false){
                        layer.msg(data.msg,{icon: 5});
                        return false;
                    }
                    return false;
                },error: function(){
                    layer.msg('操作失败！',{icon: 5});
                    return false;
                }
            });
            @else
            layer.msg('请先登录！',{icon: 5});
            @endif
        })

        $('.follow').click(function(){
            @if (\Auth::check())
            var lecturer_id = $(this).data('id');
            $.ajax({
                type: 'post',
                url: '{{route('follow.lecturer')}}',
                data: {lecturer_id: lecturer_id},
                success: function(data){
                    if(data.status == false){
                        layer.msg(data.msg,{icon: 5});
                        return false;
                    }
                    layer.msg(data.msg,{icon: 1});
                    setTimeout(function () {
                        window.location.reload()
                    }, 600);
                    return false;
                },error: function(){
                    layer.msg('关注失败！',{icon: 5});
                    return false;
                }
            })
                @else
                layer.msg('请先登录！',{icon: 5});
            @endif
        });
        $('.unfollow').click(function(){
                    @if (\Auth::check())
                   var lecturer_id = $(this).data('id');
            $.ajax({
                type: 'delete',
                url: '{{route('live.unfollow')}}',
                data: {lecturer_id: lecturer_id},
                success: function(data){
                    if(data.status == false){
                        layer.msg(data.msg,{icon: 5});
                        return false;
                    }
                    layer.msg(data.msg,{icon: 1});
                    setTimeout(function () {
                        window.location.reload()
                    }, 600);
                   return false;
                },error: function(){
                    layer.msg('操作失败！',{icon: 5});
                    return false;
                }
            })
            @else
             layer.msg('请先登录！',{icon: 5});
            @endif
        })
        $('#myTab a:first').tab('show');
    })
</script>
<script src="{{asset('homestyle/js/bootstrap-tab.js')}}"></script>

<script>
var wsAddress = '{{$wsAddress}}';
</script>
<script src="{{asset('/dist/js/jquery.barrager.min.js')}}"></script>
<script src="{{asset('/dist/js/jquery.gift.barrager.js')}}"></script>
<script src="{{asset('/homestyle/js/chat.js')}}"></script>
@stop