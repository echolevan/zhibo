@extends('mobile.layout.app')
        @section('css')
            <link href="{{asset('homestyle/m_css/live.css')}}" rel="stylesheet" type="text/css">
            <link href="{{asset('video/video-js.css')}}" rel="stylesheet">
            <link rel="stylesheet" href="{{asset('/homestyle/face/jquery.sinaEmotion.css')}}" type="text/css">
            <script src="{{asset('/homestyle/face/jquery.sinaEmotion.js')}}"></script>
            <!-- If you'd like to support IE8 -->
            <script src="{{asset('video/videojs-ie8.min.js')}}"></script>
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
<!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top"  style="margin-bottom:0px;">
    <div class="live-video">
        <div style=" width:100%; height:100%; display:block;position:absolute; left:0%; top:0%;">
            <video id="mobile-my-video" class="video-js img-responsive vjs-big-play-centered" controls preload="auto" style="width:100%; height:100%; display:block;"
                   poster="{{photoUrl($room->streams_name)}}"
                   data-setup="{}">
                <source src="{{playUrl($room->streams_name)}}" type="rtmp/flv">
                <source src="{{hlsUrl($room->streams_name)}}" type='application/x-mpegURL'>
            </video>
        </div>

        <ul style="line-height:50px;" class="live-con">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href=""><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;"><img src="/homestyle/m_img/back1.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center"> </li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right"><a href=""><i style="width:24px; height:24px; display:block; float:right; margin-top:15px; margin-right:10px;"></i></a></li>
        </ul>

    </div>
    <ul class="nav nav-tabs live-tab" role="tablist">
        <li role="presentation" class="active"><a href="#chat" aria-controls="#chat" role="tab" data-toggle="tab">聊天</a></li>
        <li role="presentation"><a href="#answer" aria-controls="#answer" role="tab" data-toggle="tab">付费提问</a></li>
        <li role="presentation"><a href="#rank" aria-controls="#rank" role="tab" data-toggle="tab">排行</a></li>
    </ul>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="user-dynamic-tab" style=" margin-top:250px;">
    <div class="container">
        <div class="row">
            <!-- Tab panes -->
            <div class="tab-content">
                <!--tab聊天-->
                <div role="tabpanel"  class="tab-pane active scroll-sidebar-cont" id="chat" style=" margin-top:-17px;">
                    <div class="live-att">
                        <div class="att-name">
                            <div class="p-img"><img src="{{$room->lecturer->user->thumb}}" class="img-responsive img-circle"></div>
                            <div class="a-txt">
                                <p style="font-size:1.2em;">{{$room->lecturer->user->name}}</p>
                                <p style="font-size:1em;">粉丝: {{App\Models\Follow::where('user_id',$room->lecturer->user_id)->count()}}</p>
                            </div>
                        </div>
                        @if(Auth::guest())
                            <button data-id="{{$room->lecturer->user_id}}" type="button" class="att-btn follow">+关注</button>
                        @else
                            @if(empty(App\Models\Follow::where('user_id',$room->lecturer->user_id)->where('my_id',Auth::user()->id)->first()))
                            <button data-id="{{$room->lecturer->user_id}}" type="button" class="att-btn follow">+关注</button>
                                @else
                                <button data-id="{{$room->lecturer->user_id}}" type="button" class="att-btn follow">已关注</button>
                                @endif
                            @endif

                    </div>
                    <div class="live-chat chatInfo ">
<!--                        <p><span style="color:#ff4436">旭日之光: </span><span>00000000000000000000刷点礼物，机会就来啦！哈哈</span></p>
                        <p><span style="color:#ff4436">只看v不哭: </span><span> 666666</span></p>
                        <p><span style="color:#ff4436">旭日之光: </span><span>刷点礼物，机会就来啦！哈哈</span></p>-->
                        <p><span style="color:#ff4436">1111111111111</span></p>
                        <p><span style="color:#ff4436">22222222222</span></p>
                    </div>
                    <div style="height:50px;"></div>



                    <div class="navbar navbar-default navbar-fixed-bottom dy-gz" style="background:#ffffff;">
                        <div class="input-group live-chat-input"> <span class="bq-btn"> <img id="face" src="/homestyle/m_img/zb-bq.png" class="img-responsive img-circle"> </span>
                            <input type="text" id="msgInput" class="chat-input msg" placeholder="发个弹幕呗~">
            <span class="f-btn">
            <button type="button" id="btnCommit" class=""><img src="/homestyle/m_img/zb-set.png" class="img-responsive"></button>
            </span> <span class="gifts-img">  <img id="showgift"  data-toggle="modal" data-target="#myModal" src="/homestyle/m_img/zb-gift.png" class="img-responsive"></span> </div>
                    </div>
                </div>
                <!--tab聊天结束-->

                <!--tab付费提问-->
                <div role="tabpanel" class="tab-pane" id="answer">
                    <ul class="questionBox">
                        <li>
                            <!--<div class="wen-2"> <a href=""> <i><img src="/homestyle/m_img/wen.png" width="20" height="20"></i> <span class="question">000999这只股，几天走势如何？</span><span>查看详情></span></a> </div>-->
                        </li>
                    </ul>
                    <div style="height:50px;"></div>

                    <div class="navbar navbar-default navbar-fixed-bottom dy-gz" style="background:#ffffff; bottom: 60px;">
                        <div class="input-group live-chat-input">
                            <span class="bq-btn" style="padding-top: 10px;"> 金额 </span>
                            <input type="text" name="reply_price" class="chat-input" placeholder="金额越高问题越靠前~">
                            <span class="f-btn">金币</span>
                           <span class="gifts-img">  </span> </div>
                    </div>
                    <div class="navbar navbar-default navbar-fixed-bottom dy-gz" style="background:#ffffff;">
                        <div class="input-group live-chat-input"> <span class="bq-btn" style="padding-top: 10px;"> 问题 </span>
                            <input type="text" id="title" class="chat-input" placeholder="请输入问题~">
                            <span class="f-btn">
                            <button type="button" class="reply"><img src="/homestyle/m_img/zb-set.png" class="img-responsive"></button>
                            </span> <span class="gifts-img">  </span> </div>
                    </div>
                </div>
                <!--tab付费提问结束-->

                <!--tab排行-->
                <div role="tabpanel" class="tab-pane contribution-list" id="rank">
                    <ul>
                        <?php $i = 1 ?>
                        @foreach($GifTop as $top)
                        <li>
                            <div class="info">
                                <div class="fortune"> <i class="red-diamond"></i>{{$top->sum_price}}</div>
                            </div>
                            <div class="user">
                                {{$i++}}
                                <span class="nick ellipsis"> <i class="noble noble-1"></i>{{$top->send_name}}</span>
                            </div>
                        </li>
                            @endforeach
                    </ul>
                </div>
                <!--tab排行结束-->

            </div>
        </div>
    </div>
</div>

<!-- 赠送礼物 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 10">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">赠送礼物</h4>
            </div>
            <div class="modal-body">
                <div class=" giftBox">

                    <ul >
                        <?php $s = 1 ?>
                        @foreach($gifs as $g)
                        <li data-id="{{$g->id}}" data-img="{{$g->img}}" id="gift_{{$g->id}}" source="{{$g->gif}}"><a href="javascript:void (0);"> <img  id="giftImg{{$s++}}" src="{{$g->img}}"> </a></li>
                        @endforeach

                    </ul>
                    <div style="clear: both"></div>

                    <div class="live-chat-input" id="gift-select-img-id">
                        礼物数量：<input type="text" name="gift" id="giftNum" class="chat-input" value="1" placeholder="数量~">
                    </div>
                    <br/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary give">赠送</button>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="barrage_system" value="{{$room->barrage}}" >
<input type="hidden" id="barrage_default" value="1">
<input type="hidden" id="speak" value="{{$room->speak}}">
<span id="userData" userData='{{$userData}}' question="{{$messages}}"> </span>
@stop
   @section('js')
       <script src="{{asset('video/video.js')}}"></script>
       <script type="text/javascript">
           var myPlayer = videojs('mobile-my-video');
           videojs("mobile-my-video").ready(function(){
               var myPlayer = this;
               myPlayer.play();
           });
       </script>
<script>
var wsAddress = '{{$wsAddress}}';
$(function(){
    $('#face').SinaEmotion($('#msgInput'));

    $('.reply').click(function(){
            var reply_price = $('input[name=reply_price]').val();
            var title = $('#title').val();
            if(reply_price == ''){
                layer.open({content: '请填输入金额！',skin: 'msg',time: 2});
                return false;
            }
            if(reply_price < 1){
                layer.open({content: '金额不能小于一金币！',skin: 'msg',time: 2});
                return false;
            }
            if(title == ''){
                layer.open({content: '请填写问题！',skin: 'msg',time: 2});
                return false;
            }
            var data = {
                to_user_id: '5',
                title: title,
                reply_price: reply_price
            }
            $.ajax({
                type: 'post',
                url: '/message/question',
                data: data,
                success: function(data){
                    if(data.status == false){
                        layer.open({content: data.msg,skin: 'msg',time: 2});
                        return false;
                    }
                    layer.open({content: data.msg,skin: 'msg',time: 2});
                    setTimeout(function () {
                        parent.layer.closeAll();
                    }, 600);
                    $('input[name=reply_price]').val("");
                    $('#title').val("");
                    return false;
                },error: function(){
                    layer.open({content: '操作失败！',skin: 'msg',time: 2});
                    return false;
                }
            });
    });


    $('.giftBox li').click(function(){
            $('.giftBox li').removeClass('active');
            $(this).addClass('active');
            $('.gift').remove();
            var gift_id = $(this).data('id');
            var img = $(this).data('img');
            var gif = '<img class="gift imghide" data-id="'+gift_id+'" src="'+img+'">';
            $(gif).appendTo('#gift-select-img-id');

        });

    $('.give').click(function(){
            @if (\Auth::check())
            var number = $('input[name=gift]').val();
            var gift_id = $('.gift').data('id');
            if(gift_id == null){
                 layer.open({content: '请选择礼物！',skin: 'msg',time: 2});
                return false;
            }
            var data = {
                number: number,
                gift_id: gift_id,
                user_id: '{{$lecturer->user_id}}'
            };
            $.ajax({
                type: 'post',
                url: '{{route('give.gift')}}',
                data: data,
                success: function(data){
                    if(data.status == false){
                        layer.open({content: data.msg,skin: 'msg',time: 2});
                        return false;
                    }
                    $('#myModal').modal('hide');
                    return false;
                },
                error: function(){
                    layer.open({content: '操作失败！',skin: 'msg',time: 2});
                    return false;
                }
            });
            @else
            layer.open({content: '请先登录！',skin: 'msg',time: 2});
            @endif
        });

    $('.follow').click(function(){
                @if (\Auth::check())
         var lecturer_id = $(this).data('id');
         var _this = $(this);
        $.ajax({
            type: 'post',
            url: '{{route('follow.lecturer')}}',
            data: {lecturer_id: lecturer_id},
            success: function(data){
                if(data.status == false){
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
                layer.open({
                    content: data.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                setTimeout(function () {
                    _this.text('已关注');
                }, 600);
                return false;
            },error: function(){
                layer.open({
                    content: '关注失败！'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                return false;
            }
        })
        @else
        layer.open({
            content: '请先登录！'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
        @endif
})
})
</script>
<script src="{{asset('/dist/js/jquery.gift.barrager.js')}}"></script>
<script src="{{asset('/homestyle/m_js/chatmobile.js')}}"></script>
<!--<script src="{{asset('/dist/js/jquery.barrager.min.js')}}"></script>-->
@stop