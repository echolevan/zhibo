@extends('mobile.layout.app')
@section('css')
    <link href="{{asset('video/video-js.css')}}" rel="stylesheet">
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
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="{{route('mobile.back_live')}}"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;">
                        <img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">{{$details->title}}</a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="dynamic" style="margin-top:50px;width:100%; height:40%; display:block;position:absolute; left:0%;">
    <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" style="width:100%; height:100%; display:block;"
           poster="http://{{$details->thumb}}"

           data-setup="{}">
        <source src="http://{{$details->url}}" type="video/mp4">
    </video>
</div>
    <div class="clear"></div>

<div class="no-comment" style="position:absolute;margin-top: 320px;">
    <p style="border-bottom:#ddd solid 1px; text-indent:10px;"><span>全部评论</span> <span>{{$comments->count()}}</span></p>
    <ul class="comment append">
        @foreach($comments as $comment)
            @if(!empty($comment->user))
                <li>
                    <div>
                        <div class="img">
                            <img src="{{$comment->user->thumb}}" class="img-responsive img-circle" alt="60x60">
                        </div>
                        <div style=" width:82%;display:inline-block; margin-left:10px;  border-bottom:#ddd 1px solid;">
                            <div class="co-name">
                                <div class="pull-left">
                                    @if(empty($comment->user->name))
                                        <p style="font-size:1.1em; line-height:20px;">{{$comment->user->oauth->nickname}}</p>
                                    @else
                                        <p style="font-size:1.1em; line-height:20px;">{{$comment->user->name}}</p>
                                    @endif
                                    <p style="color:#999; line-height:20px;">{{$comment->created_time}}</p>
                                </div>
                                <div style="display:inline-block; margin-top:5px;" class="pull-right">
                                    <a  href="{{route('mobile.live.reply',[$details->id,$comment->id])}}"><img src="/homestyle/m_img/pl.png" class="img-responsive"></a>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="co-name">
                                <p>{{$comment->contents}}</p>
                                @if(!$comment->children->isEmpty())
                                    <div class="reply">
                                        @foreach($comment->children as $children)
                                            @if(!empty($children->user))
                                                <div class="reply-txt">
                                                    @if(empty($children->user->name))
                                                        <span style="color:#4975b0;">{{$children->user->oauth->nickname}}</span>
                                                    @else
                                                        <span style="color:#4975b0;">{{$children->user->name}}</span>
                                                    @endif

                                                    <span>：{{$children->contents}}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            @endif
        @endforeach
    </ul>
</div>
    <div class="clear"></div>
<!--主界面内容end-->
<!--底部固定导航-->
<div class="navbar navbar-default navbar-fixed-bottom" style="background:#e6e6e6;">
    <form class="form-group p-dynamic">
        <input type="text" name="comment" class="form-control t-input no-input" placeholder="评论回复"  style="width:80%;">
        <button type="button" class="btn btn-info addcomment" style="float:right;margin-top: -33px;">提交</button>
    </form>
</div>
<!--底部固定导航end-->
@stop
@section('js')
    <script src="{{asset('video/video.js')}}"></script>
    <script type="text/javascript">
        var myPlayer = videojs('my-video');
        videojs("my-video").ready(function(){
            var myPlayer = this;
            //myPlayer.play();
        });
    </script>
    <script>
        $(function(){
            $('.addcomment').click(function(){
                        @if(\Auth::check())
                   var back_live_id = '{{$details->id}}';
                var contents = $('input[name=comment]').val();
                if(contents == ''){
                    layer.open({
                        content: '评论不能为空！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
                if(contents.length > 50){
                    layer.open({
                        content: '请限制 在50个字以内！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
                var data = {
                    back_live_id: back_live_id,
                    contents: contents
                };
                $.ajax({
                    type: 'post',
                    url: '{{route('add.back_live_comment')}}',
                    data: data,
                    success: function(data){
                        if(data.status == false){
                            layer.open({
                                content: data.msg
                                ,skin: 'msg'
                                ,time: 2 //2秒后自动关闭
                            });
                            return false;
                        }
                        var comment = '<li>'+
                                '<div>'+
                                '<div class="img"><img src="'+ data.info.thumb +'" class="img-responsive img-circle" alt="60x60"></div>'+
                                '<div style=" width:82%;display:inline-block; margin-left:10px;  border-bottom:#ddd 1px solid;">'+
                                '<div class="co-name">'+
                                '<div class="pull-left">'+
                                '<p style="font-size:1.1em; line-height:20px;">'+ data.info.name +'</p>'+
                                '<p style="color:#999; line-height:20px;">'+ data.info.time +'</p>'+
                                '</div>'+
                                '<div style="display:inline-block; margin-top:5px;" class="pull-right">'+
                                '<a href="##"><img src="/homestyle/m_img/pl.png" class="img-responsive"></a>'+
                                '</div>'+
                                '</div>'+
                                '<div class="clear"></div>'+
                                '<div class="co-name">'+
                                '<p>'+ data.info.contents +'</p>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                                '</li>';
                        $(comment).appendTo('.append');
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                        $('input[name=comment]').val('');
                    },error: function(){
                        layer.open({
                            content: '操作失败！'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                        return false;
                    }
                });
                @else
               layer.open({
                    content: '请先登陆！'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                @endif
            });

        })
    </script>
@stop