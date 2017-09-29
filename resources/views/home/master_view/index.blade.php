@extends('home.layout.app')

@section('css')
    <link href="{{asset('/homestyle/css/second.css')}}" rel="stylesheet" type="text/css">
    <style>
        .color{
            color:red;
        }
        .breadcrumb{margin: 10px}
        .breadcrumb>li+li:before {
            padding: 0 5px;
            color: #bbb;
            content: ">";
        }
    </style>
@stop
@section('content')
    <div class="container">
        <?php 
        $id = isset($_GET['id']) ?  intval($_GET['id']) : 0;
        $txt = "高手观点";
        $uri = "/master-view";
        if ($id ==1){
            $txt = "观点";
            $uri = "/master-view?id={$id}";
        }else if($id ==2){
            $txt = "文章";
            $uri = "/master-view?id={$id}";
        }
        ?>
        <ol class="breadcrumb">
            <li><a href="/">构牛网</a></li>
            <li><a href="<?php echo $uri;?>"><?php echo $txt;  ?></a></li>
          </ol>
        <div class="row">
            <div class="masterview" style="margin-top:0px;">
                <div class="masterview-ban pull-left"><img src="/homestyle/images/topban.jpg" width="900" height="230"></div>
                <div class="pull-right masterview-num">
                    <div class="masterview-num-con">
                        <div class="masterview-num-title">
                            <span class="masterview-num-tit1 pull-left">
                                <strong>上证指数</strong><b>（000001.SH）</b></span>
                            <span class="masterview-num-btn pull-right">沪深</span>
                        </div>
                        <div class="clear"></div>
                        <div class="masterview-data">
                            @if(!empty($f['rate'] ))
                            <div class="pull-left masterview-data-num ">
                                <span class="dot @if($f['rate'] > 0) color @endif">{{$f['dot']}}</span>@if($f['rate'] > 0)<small class="status color">↑</small>@else<small class="status">↓</small>@endif
                            </div>
                            <div class="pull-right masterview-data-num1">
                                <p class="nowPic @if($f['rate'] > 0) color @endif">{{substr($f['nowPic'],0,-2)}}</p>
                                <p class="rate @if($f['rate'] > 0) color @endif">{{$f['rate']}}%</p>
                            </div>
                                @endif
                        </div>
                        <div class="clear"></div>
                        <p style="color:#626262;">更新时间：{{date('Y-m-d h:i:s')}}</p>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="masterview">
                <div class="pull-left masterview-left">
                    <div class="masterview-left-tab">
                        <ul class="nav nav-tabs masterview-left-tablist" id="myTab">
                            <li class="@if($active == 1 or empty($active)) active @endif"><a href="{{route('master.view',array('id'=>1))}}">观点</a></li>
                            <li class="@if($active == 2) active @endif"><a href="{{route('master.view',array('id'=>2))}}" >文章</a></li>
                        </ul>
                        <div class="clear"></div>
                        <div style="margin:10px 200px 0 200px; text-align: center;">
                            <a href="?id={{Request::input('id')}}&type=1"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-fire" aria-hidden="true"></span> 最 热</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="?id={{Request::input('id')}}"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 最 新</button></a>
                        </div>
                        <div class="tab-content">

                            <div class="tab-pane active" id="view">
                                <div class="clear"></div>
                                <div class="message-1">
                                    <ul>
                                        @foreach($views as $v)
                                            @if(!empty($v->user))
                                        <li>
                                            <div class="pull-left">
                                                <div class="mymessage">
                                                    <a href="{{route('customer.live',$v->user_id)}}" target="_blank">
                                                        @if(empty($v->thumb))
                                                            <img src="{{$v->user->thumb}}" width="60" height="60">
                                                        @else
                                                            <img src="{{$v->thumb}}" width="60" height="60">
                                                        @endif
                                                    </a>

                                                </div>
                                                <div class="mytxt">
                                                    <div class="release">
                                                        @if($v->type ==1)
                                                        <h4><a class="artDesc" href="{{route('details',$v->id)}}" target="_blank">
                                                                @if(empty($v->tags))
                                                                    股票：
                                                                @else
                                                                    {{$v->tags}}
                                                                @endif
                                                                {{$v->description}}热评</a></h4>
                                                        @endif
                                                            @if($v->type ==2)
                                                                <h4><a class="artDesc" href="{{route('details',$v->id)}}" target="_blank">{{$v->title}}</a></h4>
                                                            @endif
                                                        <div class="re-person">发布者：
                                                            @if(empty($v->user->name))
                                                                <span>{{$v->user->oauth->nickname}}</span>
                                                            @else
                                                                <span>{{$v->user->name}}</span>
                                                            @endif
                                                        </div>
                                                        <div class="re-txt">
                                                            <p><a class="artDesc" href="{{route('details',$v->id)}}" target="_blank">{!! subtext(strip_tags($v->contents),155)  !!}</a> </p>
                                                        <div class="re-txt" style="height:40px;">
                                                            <div class="pull-left"><i class="glyphicon glyphicon-time"></i> {{$v->ctime}}</div>
                                                            <div class="pull-right read">
                                                                <span>阅读：<strong>{{$v->count}}人</strong></span>
                                                                <span>评论：<strong>{{$v->comments->count()}}条</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                </div>
                                        </li>
                                        <div class="clear"></div>
                                            @endif
                                            @endforeach
                                    </ul>
                                    {!! $views->appends(Request::all())->links() !!}
                                </div>
                            </div>
                            @if($active == 2)
                            <div class="tab-pane" id="art">
                                <div class="message-1">
                                    <ul>
                                        @foreach($views as $article)
                                            @if(!empty($article->user))
                                        <li>
                                            <div class="pull-left m-left">
                                                <div class="mymessage">
                                                    <a href="{{route('customer.live',$article->user_id)}}" target="_blank">
                                                        @if(empty($article->thumb))
                                                            <img src="{{$article->user->thumb}}" width="60" height="60">
                                                        @else
                                                            <img src="{{$article->thumb}}" width="60" height="60">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="mytxt">
                                                    <div class="release-1">
                                                        <h4><a class="artDesc" href="{{route('details',$v->id)}}" target="_blank">{{$article->title}}</a></h4>
                                                        <div class="re-person">发布者：
                                                            @if(empty($article->user->name))
                                                                <span>{{$article->user->oauth->nickname}}</span>
                                                                @else
                                                                <span>{{$article->user->name}}</span>
                                                                @endif
                                                        </div>
                                                        <div class="re-txt">
                                                           <p>{!! subtext(strip_tags($article->contents),155) !!}</p>

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
                                            <div class="pull-right m-right">
                                                <img src="/homestyle/images/t-pic.png" width="152" height="102"></div>
                                                </div>
                                        </li>
                                            @endif
                                            @endforeach
                                    </ul>
                                    {!! $views->appends(Request::all())->links() !!}
                                </div>
                            </div>
                                @endif
                        </div>
                        </div>
                    </div>

                <div class="pull-right masterview-right">
                    <div class="masterview-right-hot">
                        <div class="masterview-hot-title"> <span><i></i> 热门股票分析</span> </div>
                        <div class="masterview-hot-con">
                            <ol>
                                @foreach($hot_views as $k=>$h)
                                        @if(!empty($h->user))
                                <li
                                        @if($k+1 == 1)
                                        class="r-on"
                                        @endif
                                > <a href="{{route('details',$h->id)}}"><span>{{$k+1}}</span>
                                            @if(empty($v->tags))
                                            股票：
                                            @else
                                            {{$v->tags}}
                                            @endif
                                        {{$h->description}}热评</a> </li>
                                        @endif
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
    <script src="{{asset('homestyle/js/bootstrap-tab.js')}}"></script>
    <script>
        $(function(){
            var refresh = function () {
                $.ajax({
                    type: 'get',
                    url: '{{route('financeInfo')}}',
                    success: function(data){
                        if(data.dot > 0){
                            $('.status').text('↑').addClass('color');
                            $('.dot').addClass('color');
                            $('.nowPic').addClass('color');
                            $('.rate').addClass('color');
                        }
                        if(data.dot < 0){
                            $('.status').text('↓').removeClass('color');
                            $('.dot').removeClass('color');
                            $('.nowPic').removeClass('color');
                            $('.rate').removeClass('color');
                        }
                        $('.dot').text(data.dot)
                        $('.nowPic').text(data.nowPic)
                        $('.rate').text(data.rate)
                    }
                })
            }
            //定时执行
            setInterval(refresh, 180000)
        })
    </script>
    @stop