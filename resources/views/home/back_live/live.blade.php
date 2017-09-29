@extends('home.layout.app')
@section('css')
    <link href="{{asset('/homestyle/css/second.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/jpage/css/jPages.css" >
    <link rel="stylesheet" href="/jpage/css/animate.css">
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
<div class="container-fluid">
    <div class="row">
        <div class="liveback">
            <div class="container">
                <div style="margin-top:30px;">
                    <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" style="width:100%; height:600px;; display:block;"
                           poster="http://{{$back_live->thumb}}"

                           data-setup="{}">
                        <source src="http://{{$back_live->url}}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
        <div class="container">
            <!--基本介绍-->
            <div class="basic-info">
                <div class="basic-left">
                    <div class="basic-left-img">
                        <a href="{{route('customer.live',$back_live->user_id)}}" target="_blank">
                            <img src="{{$back_live->user->thumb}}" width="90" height="90" class="img-circle">
                        </a>

                    </div>
                    <div class="basic-left-txt">
                        <div class="basic-left-name">{{$back_live->title}}</div>
                        <div class="basic-left-tec">讲师：{{$back_live->user->name}}</div>
                        <div class="basic-left-time"><i class="glyphicon glyphicon-time"></i> <span> 上传时间：{{$back_live->created_time}}</span></div>
                    </div>
                </div>
                <div class=" pull-right">
                    <div class="basic-left-num">播放次数：{{$back_live->count}}</div>
                    <div class="basic-share"> <span class="basic-share-title">分享：</span>
                        <!-- JiaThis Button BEGIN -->
                        <div class="jiathis_style_32x32">
                            <a class="jiathis_button_qzone"></a>
                            <a class="jiathis_button_tsina"></a>
                            <a class="jiathis_button_weixin"></a>
                            <a class="jiathis_button_cqq"></a>
                            <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
                        </div>
                        <script type="text/javascript" >
                            var jiathis_config={
                                summary:"",
                                shortUrl:false,
                                hideMore:true
                            }
                        </script>
                        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                        <!-- JiaThis Button END -->


                    </div>
                </div>
            </div>
            <!--基本介绍结束-->
            <div class="comment-area">
                <!--发表评论-->
                <div class="comment-area-con">
                    <div class="comment-send">
                        <form>
                            <textarea name="contents" cols="88" rows="3" class="sendtext contents" placeholder="说说你的见解"></textarea>
                            <button type="button" class="sendbtn addcomment">评论</button>
                        </form>
                    </div>
                </div>
                <!--发表评论结束-->
                <div class="clear"></div>
                <div class="comment-area-num">
                    <div class="comment-num-title">
                        <div class="comment-num-title-line"></div>
                        <div class="comment-num-title-txt">{{$comments->count()}}条评论条评论</div>
                    </div>
                    <div class=" comment-num-con">
                        <ul>
                            <ul class="comments" id="comments">
                                @foreach($comments as $c)
                                    @if(!empty($c->user))
                                        <li>
                                            <div class="comment-num-img">
                                                @if(empty($c->user->thumb))
                                                    <img src="{{$c->user->oauth->avatar_url}}" class="img-responsive">
                                                @else
                                                    <img src="{{$c->user->thumb}}" class="img-responsive">
                                                @endif
                                            </div>
                                            <div class=" comment-num-txt">
                                                <div class="comment-num-user">
                                                    @if(empty($c->user->name))
                                                        <span style="color:#cb945e;">{{$c->user->oauth->nickname}}</span>
                                                    @else
                                                        <span style="color:#cb945e;">{{$c->user->name}}</span>
                                                    @endif
                                                    <span>：{{$c->contents}}</span>
                                                </div>
                                                <div class="comment-num-user">
                                                    <span style="color:#999;"  class="pull-left">{{$c->created_time}}</span>
                                                    <span class="pull-right text-right">
                                                        <a data-id="{{$c->id}}" href="javascript:void (0);" class="reply">回复</a>
                                                    </span>
                                                </div>
                                                @if(!$c->children->isEmpty())
                                                    @foreach($c->children as $children)
                                                        @if(!empty($children->user))
                                                            <div class="comment-num-reply">
                                                                <div class="comment-num-user">
                                                                    @if(empty($children->user->name))
                                                                        <span style="color:#cb945e;">{{$children->user->oauth->nickname}}</span>
                                                                    @else
                                                                        <span style="color:#cb945e;">{{$children->user->name}}</span>
                                                                    @endif
                                                                    <span>：{{$children->contents}}</span>
                                                                </div>
                                                                <div class="comment-num-user">
                                                                    <span style="color:#999;" class="pull-left">{{$children->created_time}}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </ul>
                        <div class="comment-lookmore">
                            @if($comments->count() > 5)
                                <div aria-label="Page navigation">
                                    <div class="holder"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @stop
@section('js')
    <script type="text/javascript" src="/jpage/js/tabifier.js"></script>
    <script src="/jpage/js/jPages.js"></script>
    <script type="text/javascript" src="/jpage/js/highlight.pack.js"></script>
    <script src="{{asset('video/video.js')}}"></script>
    <script type="text/javascript">
        var myPlayer = videojs('my-video');
        videojs("my-video").ready(function(){
            var myPlayer = this;
            myPlayer.play();
        });
    </script>

    <script>
        $(function(){
            $('.addcomment').click(function(){
                        @if(\Auth::check())
                     var back_live_id = '{{$back_live->id}}';
                var contents = $('.contents').val();
                if(contents == ''){
                    layer.msg('评论不能为空！');
                    return false;
                }
                if(contents.length > 50){
                    layer.msg('请限制 在50个字以内！');
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
                        console.log(data);
                        if(data.status == false){
                            layer.msg(data.msg);
                            return false;
                        }
                        layer.msg(data.msg, {icon: 1});
                        var comment = '<li>'+
                                '<div class="comment-num-img">'+
                                '<img src="'+ data.info.thumb +'" class="img-responsive">'+
                                '</div>'+
                                '<div class=" comment-num-txt">'+
                                '<div class="comment-num-user">'+
                                '<span style="color:#cb945e;">'+ data.info.name +'</span><span>：'+ data.info.contents +'</span>'+
                                '</div>'+
                                '<div class="comment-num-user">'+
                                '<span style="color:#999;">'+ data.info.time +'</span>'+
                                '<span class="pull-right text-right">'+
                                '<a href="javascript:void (0);">回复</a>'+
                                '</span>'+
                                '</div>'+
                                '</div>'+
                                '</li>';
                        $(comment).appendTo(".comments").fadeIn(1000);
                        $('.contents').val('');
                    },error: function(){
                        layer.msg('操作失败', {icon: 5});
                        return false;
                    }
                });
                @else
          layer.msg('发表评论请先登录！', {icon: 5});
                @endif
                });

            $('.reply').click(function(){
                        @if(\Auth::check())
                     var id = $(this).data('id');
                layer.prompt({
                    title: '请填写你的回复', //不显示标题
                },function(val, index){
                    if(val == ''){
                        layer.msg('请填写你的回复！');
                        return false;
                    }
                    var contents = val;
                    var back_live_id = '{{$back_live->id}}';
                    var data = {
                        id: id,
                        contents: contents,
                        back_live_id: back_live_id
                    };
                    $.ajax({
                        type: 'post',
                        url: '{{route('reply.back_live_comment')}}',
                        data: data,
                        success: function(data){
                            layer.msg(data.msg, {icon: 1});
                            setTimeout(function () {
                                window.location.reload()
                            }, 1000);
                        },error: function(){
                            layer.msg('回复失败！', {icon: 5});
                            return false;
                        }
                    })
                    layer.close(index);
                })
                @else
        layer.msg('发表评论请先登录！', {icon: 5});
                @endif
                    });

        })
    </script>
    <script>
        /* when document is ready */
        $(function() {
            /* initiate plugin */
            $("div .holder").jPages({
                containerID: "comments",
                previous : "上一页",
                next : "下一页",
                perPage : 5,
            });
        });
    </script>
    @stop