@extends('home.layout.app')
@section('css')
    <style>
        .basic-info {
            width: 100%;
            background: #fff;
            margin-top: 30px;
            padding: 15px 0;
            height: auto !important;
            overflow:hidden;
        }
        .basic-info .basic-left-1 {
            width:700px;
            float:left;
        }
        .basic-info .basic-left-img-1 {
            width: 60px;
            height: 60px;
            display: block;
            float: left;
            margin-left: 20px;
        }
        .basic-info .basic-left-txt {
            width:580px;
        }
        .basic-info .basic-left-txt .basic-left-name {
            margin-top:10px;
        }
        .basic-info .delivery-num {
            width:100%;
            padding:20px 0;
            border-bottom:#ddd 1px solid;
            overflow:hidden;
        }
        .basic-info .delivery-num .order-zsy {
            width:50%;
            float:left;
            display:block;
            color: #fe6454;
            font-size:20px;
        }
        .basic-info .delivery-num .order-fbnum {
            width:50%;
            float:right;
            display:inline-block;
            font-size:18px;
            margin-top:20px;
        }
        .basic-info .delivery-num .order-fbnum input {
            width:120px;
            padding:10px;
            border-radius:5px;
            color: #fe6454;
            text-align:center;
            font-size:18px;
        }
        .basic-left-txt .about {
            padding:10px 0;
        }
        .basic-left-txt .about #clamp-this-module {
            display:inline-block;
            margin: 0px;
            color: #666;
            display: -webkit-box;
            text-overflow: ellipsis;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .basic-left-txt .about a {
            color:#4c65e4;
            text-align:right;
        }
        .table {
            margin:0px;
        }
        .table thead {
            background:#fff1f4;
        }
        .table tbody tr td {
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background:#f5f5f5;
        }
        .table .admin-name {
            color:#ffa829;
        }
        .table .total-income {
            color:#ff4436;
        }
        .table .total-income-1 {
            color:#2bc35d;
        }
        .table .look {
            color:#ff4436;
        }
        .table img {
            text-align:center;
        }
        .table tr {
            height:40px;
            line-height:40px;
        }
        .table tr th {
            padding:0px;
            line-height:40px;
            text-align:center;
            vertical-align: middle;
        }
        .table tr td {
            padding:0px;
            line-height:40px;
            text-align:center;
            vertical-align: middle;
        }
        .table > thead > tr > th {
            vertical-align: middle !important;
            border-bottom: 1px solid #ddd;
        }
        .delivery-detail {
            width:100%;
            margin:auto;
            margin-top:20px;
            background:#fff;
            overflow:hidden;
            height:auto;
            border-top: 2px #ff4436 solid;
        }
        .comment-pf {
            width: 1005px;
            height: 40px;
            background: #fff;
            display: inline-block;
        }
    </style>
    <link href="/homestyle/css/second.css" rel="stylesheet" type="text/css">
    @stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <!--基本介绍-->
                <div class="basic-info">
                    <div class="basic-left-1">
                        <div class="basic-left-img-1"> <img src="{{$check_user->thumb}}" width="60" height="60" class="img-circle"> </div>
                        <div class="basic-left-txt">
                            <div class="basic-left-name">{{$check_user->name}}</div>
                            <div class="delivery-num">
                                <div class="order-zsy">
                                    <p><span style="font-size:48px;">{{$sum*100}}</span> <span style="position:relative; top:10px;">%</span></p>
                                    <p style="color:#666; font-size:16px; margin-left:25px;">总收益率</p>
                                </div>
                                <div class=" order-fbnum"> <span>共发布交割单</span>
                                    <input type="text" value="{{$count}}">
                                    <span>个</span> </div>
                            </div>
                            <div class="about">
                                <p><span style="float:left;">个人简介：</span><span id="clamp-this-module">{{$check_user->sign}}</span>
                                <p>
                                <p style="text-align:right;"><a href="{{route('customer.live',$check_user->id)}}" target="_blank">更多信息 >></a></p>
                            </div>
                        </div>
                    </div>
                    <div class=" pull-right"> <img src="/homestyle/images/b3.jpg" width="460" height="258"></div>
                </div>
                <!--基本介绍结束-->
                <div class="clear"></div>
                <div class="delivery-detail">
                    <table class="table ">
                        <caption class="text-left" style="height:50px; line-height:32px;">
                            <span style="margin-left:10px; font-size:18px; font-weight:bold;">综合评分
                                <img @if($evaluate >= 1) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                <img @if($evaluate >= 2) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                <img @if($evaluate >= 3) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                <img @if($evaluate >= 4) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                <img @if($evaluate >= 5) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                            </span>
                        </caption>
                        <thead>
                        <tr>
                            <th>日期</th>
                            <th>操作</th>
                            <th>证券代码</th>
                            <th>证券名称</th>
                            <th>成交数量</th>
                            <th>成交均价</th>
                            <th>发生金额</th>
                            <th>后资金额</th>
                            <th>交易市场</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($details as $d)
                        <tr>
                            <td>{{date('Y-m-d',strtotime($d->time))}}</td>
                            <td>{{$d->operate}}</td>
                            <td class="admin-name">{{$d->code}}</td>
                            <td>{{$d->name}}</td>
                            <td>{{$d->number}}</td>
                            <td>{{$d->t_price}}</td>
                            @if($d->h_price > 0)
                                <td class="total-income-1">{{$d->h_price}}</td>
                                @else
                                <td class="total-income">{{$d->h_price}}</td>
                                @endif
                            <td>{{$d->price}}</td>
                            <td class="total-income">{{$d->market}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="comment-area">
                    <!--发表评论-->
                    <div class="comment-area-con">
                        <div style=" width:1005px;display:inline-block">
                            <div class="comment-pf">
                                <p>
                                    <span class="lighten">
                                        <a style="position:relative; top:2px; color:#F00;">*</a>
                                        给交割单打分: <img class="start1" src="/homestyle/images/star.png" width="16" height="14">
                                        <img class="start2" src="/homestyle/images/star.png" width="16" height="14">
                                        <img class="start3" src="/homestyle/images/star.png" width="16" height="14">
                                        <img class="start4" src="/homestyle/images/star.png" width="16" height="14">
                                        <img class="start5" src="/homestyle/images/star.png" width="16" height="14">
                                    </span></p>
                            </div>
                            <div class="comment-send">
                                <form>
                                    <textarea name="contents" cols="88" rows="3" class="sendtext contents" placeholder="说说你的见解"></textarea>
                                    <button type="button" class="sendbtn">评论</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--发表评论结束-->
                    <div class="clear"></div>
                    <div class="comment-area-num">
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
    </div>
    @stop
@section('js')
    <script>
        $(function(){
            $('.sendbtn').click(function(){
                        @if(\Auth::check())
                var evaluate = 0;
                $('.lighten img').each(function(){
                    if($(this).attr('src') == '/homestyle/images/star.png'){
                        evaluate++;
                    }
                })

                var profit_id = '{{$profit_id}}';
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
                    profit_id: profit_id,
                    contents: contents,
                    evaluate: evaluate
                };
                $.ajax({
                    type: 'post',
                    url: '{{route('delivery.add.comment')}}',
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
                    var profit_id = '{{$profit_id}}';
                    var data = {
                        id: id,
                        contents: contents,
                        profit_id: profit_id
                    };
                    $.ajax({
                        type: 'post',
                        url: '{{route('delivery.comment.reply')}}',
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

            $('.start1').click(function(){
                $('.lighten img').attr('src','/homestyle/images/star01.jpg');
                $(this).attr('src','/homestyle/images/star.png');
            });
            $('.start2').click(function(){
                $('.lighten img').attr('src','/homestyle/images/star01.jpg');
                $(this).attr('src','/homestyle/images/star.png');
                $('.start1').attr('src','/homestyle/images/star.png');
            });
            $('.start3').click(function(){
                $('.lighten img').attr('src','/homestyle/images/star01.jpg');
                $(this).attr('src','/homestyle/images/star.png');
                $('.start1').attr('src','/homestyle/images/star.png');
                $('.start2').attr('src','/homestyle/images/star.png');
            });
            $('.start4').click(function(){
                $('.lighten img').attr('src','/homestyle/images/star01.jpg');
                $(this).attr('src','/homestyle/images/star.png');
                $('.start1').attr('src','/homestyle/images/star.png');
                $('.start2').attr('src','/homestyle/images/star.png');
                $('.start3').attr('src','/homestyle/images/star.png');
            });
            $('.start5').click(function(){
                $('.lighten img').attr('src','/homestyle/images/star01.jpg');
                $(this).attr('src','/homestyle/images/star.png');
                $('.start1').attr('src','/homestyle/images/star.png');
                $('.start2').attr('src','/homestyle/images/star.png');
                $('.start3').attr('src','/homestyle/images/star.png');
                $('.start4').attr('src','/homestyle/images/star.png');
            });
        })
    </script>
    @stop