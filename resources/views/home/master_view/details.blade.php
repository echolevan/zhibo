@extends('home.layout.app')
@section('css')
    <link href="{{asset('/homestyle/css/second.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/jpage/css/jPages.css" >
    <link rel="stylesheet" href="/jpage/css/animate.css">
    <style>
        .color{
            color:red;
        }
    </style>
    @stop
	
@section('meta_title')	
	@if($details->type == 1)
	<?php echo strip_tags($details->description)?>_构牛网
	@endif
	@if($details->type == 2)
	<?php echo strip_tags($details->title)?>_构牛网
	@endif
@stop

@section('meta_description')
<?php echo strip_tags(subtext($details->contents,80))?>
@stop



@section('content')
    <div class="container">
        <div class="row">
            <div class="masterview">
                <div class="masterview-ban pull-left"><img src="/homestyle/images/topban.jpg" width="900" height="230"></div>
                <div class="pull-right masterview-num">
                    <div class="masterview-num-con">
                        <div class="masterview-num-title">
                            <span class="masterview-num-tit1 pull-left">
                                <strong>上证指数</strong><b>（000001.SH）</b></span>
                            <span class="masterview-num-btn pull-right">沪深</span>
                        </div>
                        <div class="clear"></div>
                        @if($details->type == 1)
                            @if(!empty($f['rate']))
                        <div class="masterview-data">
                            <div class="pull-left masterview-data-num ">
                                <span class="dot @if($f['rate'] > 0) color @endif">{{$f['dot']}}</span>@if($f['rate'] > 0)<small class="status color">↑</small>@else<small class="status">↓</small>@endif
                            </div>
                            <div class="pull-right masterview-data-num1">
                                <p class="nowPic @if($f['rate'] > 0) color @endif">{{substr($f['nowPic'],0,-2)}}</p>
                                <p class="rate @if($f['rate'] > 0) color @endif">{{$f['rate']}}%</p>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <p style="color:#626262;">更新时间：{{date('Y-m-d h:i:s')}}</p>
                            @endif
                        @endif
                    </div>
                </div>

            </div>
            <div class="clear"></div>
            <div class="masterview">
                <div style="width: 900px;float: left;">
                    <div class=" pull-left masterview-left">
                        <div class="masterview-left-tab">
                            <ul class="nav nav-tabs masterview-left-tablist" id="myTab">
                            </ul>
                            <div class="clear"></div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="view">
                                    <div class="message-1" style="border:none;">
                                        <div class="mymessage">
                                            <a href="{{route('customer.live',$details->user_id)}}" target="_blank">
                                                <img src="{{$details->user->thumb}}" width="60" height="60">
                                            </a>
                                        </div>
                                        <div class="mytxt">
                                            <div class="release">
                                                @if($details->type == 1)
                                                    <h4>{{$details->description}}</h4>
                                                    @endif
                                                    @if($details->type == 2)
                                                        <h4>{{$details->title}}</h4>
                                                    @endif

                                                <div class="re-person">发布者：<span>
                                                         @if(empty($details->user->name))
                                                            {{$details->user->oauth->nickname}}
                                                             @else
                                                            {{$details->user->name}}
                                                             @endif
                                                    </span></div>
                                                <div class="de-txt">
                                                    @if(!empty($details->description))
                                                        @if(!empty($info['name']))
                                                    <p style="color:green;">{{$info['name']}} 涨跌{{$info['rate']}}% 当前价格{{$info['nowPic']}} 涨跌幅{{$info['dot']}}</p>
                                                   @endif
                                                    @endif
                                                    <p>{!! $details->contents  !!}</p> </div>


                                                <div class="clear"></div>
                                                <div class="re-txt" style="height:40px;line-height: 40px;">
                                                    <div class="pull-left"><i class="glyphicon glyphicon-time"></i> {{$details->ctime}}</div>
                                                    <div class="pull-right read"> <span>阅读：<strong>{{$details->count}}人</strong></span> | <span>评论：<strong>{{$comments->count()}}条</strong></span> </div></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class=" pull-left masterview-left" style="margin-top:20px; padding:0px;">
                        <div class="comment-area">
                            <!--发表评论-->
                            <div class="comment-area-con-1">
                                <div class="comment-send-img"><img  class="img-responsive"></div>
                                <div class="comment-send-1">
                                    <form>
                                        <textarea name="contents" cols="88" rows="3" class="sendtext contents" placeholder="说说你的见解"></textarea>
                                        <button type="button" class="sendbtn addcomment">评论</button>
                                    </form>
                                </div>
                            </div>
                            <!--发表评论结束-->
                            <div class="clear"></div>
                            <div class="comment-area-num-1">
                                <div class="comment-num-title">
                                    <div class="comment-num-title-line"></div>
                                    <div class="comment-num-title-txt">{{$comments->count()}}条评论</div>
                                </div>
                                <div class=" comment-num-con">
                                    <ul class="comments" id="comments">
                                        @foreach($comments as $c)
                                          @if(!empty($c->user))
                                        <li>
                                            <div class="comment-num-img">
                                                <img src="{{$c->user->thumb}}" class="img-responsive">
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
                <div class=" pull-right masterview-right">
                    <div class="masterview-right-hot">
                        <div class="masterview-hot-title"> <span><i></i> 热门股票分析</span> </div>
                        <div class="masterview-hot-con">
                            <ol>
                                <?php $i = 1 ?>
                                @foreach($hot_views as $h)
                                    <li
                                            @if($i == 1)
                                            class="r-on"
                                            @endif
                                    > <a href="{{route('details',$h->id)}}"><span>0{{$i++}}</span>股票：{{$h->description}}热评</a> </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                    <div class="masterview-right-ban"><img src="/homestyle/images/leftban.jpg" class="img-responsive"></div>
                    <div class="masterview-right-hot" style="margin-top:10px;">
                        <div class="masterview-hot-title"> <span><i></i> 观点牛人</span> </div>
                        <div class="masterview-hot-con">
                            <ul class="masterview-right-view-p">
                                @foreach($best as $b)
                                    @if(!empty($b->user))
                                        <li>
                                            <a href="{{route('details',$b->id)}}">
                                                <div class="masterview-people-img">
                                                    @if(empty($b->img))
                                                        <img src="{{$b->user->thumb}}" width="68" height="68">
                                                    @else
                                                        <img src="{{$b->img}}" width="68" height="68">
                                                    @endif
                                                </div>
                                                <div class="masterview-people">
                                                    <h4>{{$b->description}}</h4>
                                                    <div class="re-person">发布者：
                                                        @if(empty($b->user->name))
                                                            <span>{{$b->user->oauth->nickname}}</span>
                                                        @else
                                                            <span>{{$b->user->name}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="re-txt">
                                                        <span class="guangzhu-data" style="color:#666;">{{$b->count}}人关注</span>
                                                        <span><i class="iconfont icon-xiaoxixuanzhong01"></i> ({{$b->comments->count()}})</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
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
    <script>
        $(function(){
            $('.addcomment').click(function(){
                        @if(\Auth::check())
                     var article_id = '{{$details->id}}';
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
                    article_id: article_id,
                    contents: contents
                };
                $.ajax({
                    type: 'post',
                    url: '{{route('add.comment')}}',
                    data: data,
                    success: function(data){
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
                    var article_id = '{{$details->id}}';
                    var data = {
                        id: id,
                        contents: contents,
                        article_id: article_id
                    };
                    $.ajax({
                        type: 'post',
                        url: '{{route('reply.comment')}}',
                        data: data,
                        success: function(data){
                            if(data.status == false){
                                layer.msg(data.msg);
                                return false;
                            }
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