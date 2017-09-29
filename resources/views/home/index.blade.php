@extends('home.layout.app')
@section('css')
    <style>
        .table thead{ background:#fff1f4;}
        .table tbody tr td{vertical-align: middle;}
        .table tbody tr:hover{ background:#f5f5f5;}
        .table .admin-name{ color:#ffa829;}
        .table .total-income{ color:#ff4436;}
        .table .look{color:#ff4436;}
        .table img{ text-align:center;}
        .table tr{ height:45px; line-height:45px;}
        .table tr th{ padding:0px; line-height:45px; text-align:center;     vertical-align: middle;}
        .table tr td{ padding:0px; line-height:45px; text-align:center;     vertical-align: middle;}
        .table > thead > tr > th {
            vertical-align: middle !important;
            border-bottom: 1px solid #ddd;
        }
        .joinRoomBox{
            position: absolute;
            color: #fff;
            z-index: 99999;
            font-size: 18px;
            width: 150px;
            height: 45px;
            line-height: 40px;
            text-align: center;
            background: #ff4436;
            border: 1px solid #ee0000;
            margin: 0px auto;
            margin-top: 200px;
            margin-left: 420px;
            opacity: 0.8;
            filter:Alpha(opacity=80);
            -webkit-border-radius:4px;
            -moz-border-radius:4px;
            cursor: pointer;
            display: none;
        }
        .joinRoomBox a{color:#fff;}

        .container.js_list{
            margin-top: 30px;
            padding: 0 !important;
        }
        .container.js_list ul li{
            float: left;
            width: 14.2%;
            height: 200px;
            border: 1px solid #ddd;
            border-right: none;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: #fff;
        }

        .container.js_list ul li:hover{
            -webkit-box-shadow: 2px 2px #cbcbcb;
            box-shadow: 2px 2px 10px #cbcbcb;
        }

        .container.js_list ul a:last-child li{
            border-right: 1px solid #ddd;
        }
        .container.js_list ul li p{
            margin: 5px 0;
        }
        .container.js_list ul li div{
            width: 90%;
            margin: 0 auto;
            overflow: hidden;
            text-overflow:ellipsis;
            white-space: nowrap;
            text-align: center;
        }
        .container.view{
            padding: 0;
        }
        .container.view .left{
            width: 35%;
            float: left;
            background: #fff;
        }

        .container.view .right{
            width: 63%;
            float: right;
            background: #fff;
        }

        .container.view .left .title ul li{
            width: 25%;
            float: left;
            display: block;
            background: #f6f9fb;
            text-align: center;
            padding: 5px 15px;
            font-size: 16px;
            font-weight: bold;
        }

        .container.view .left .title ul li:hover{
            cursor: pointer;
        }

        .container.view .right .title{
            display: block;
            background: #f6f9fb;
            padding: 5px 15px;
            font-size: 16px;
            font-weight: bold;
        }


        .container.view .right .content ul li a{
            width: 650px;
            height: 20px;
            overflow: hidden;
            text-overflow:ellipsis;
            display: block;
            float: left;
        }

        .container.view .left .content ul{
            padding: 0 5px 0 25px;
        }
        .container.view .left .content ul li , .container.view .right .content ul li{
            padding: 5px;
        }

        .container.view .left .title ul li.no_border{
            border-bottom: 2px solid #ff4436;
        }

        .container.view .left .content ul li .content_title{
            width: 280px;
            height: 20px;
            overflow: hidden;
            text-overflow:ellipsis;
            display: block;
            float: left;
        }

        .container.view .left .content ul {
            min-height: 310px;
            display: none;
        }
        .container.view .right .content ul{
              min-height: 310px;
          }

        .container.view .left .content ul:first-child{
            display: block;
        }

    </style>
    @stop
@section('content')
    <div class="row">
        <!--轮播图-->
        <div class="ban-bg">
            <div class="container">
                <div class="slider-container">
                    <div class="main-slider">
                        <div class="joinRoomBox"><a href="{{route('live',[$focus->first()->lecturer->user_id,$focus->first()->lecturer->room->streams_name])}}" target="_blank">进入直播间</a></div>
                            @if(empty($focus->first()->lecturer))
                                <div class="slide-item"
                                     @if($f->id == 1)
                                     style="display:block;"
                                        @endif
                                > <img width="1800" height="956" src="{{$focus->first()->thumb}}" /> </div>
                                @else
                            <iframe id="main" src="{{route('cut.live')}}" style="width:100%;height:100%;" frameborder="no" border="0" marginwidth="0" marginheight="0"
                                    scrolling="no">
                            </iframe>

                                @endif
                    </div>
                    <ul class="thumbs clearfix">
                        @foreach($focus as $f)
                        <li @if(!empty($f->lecturer)) data-url="{{route('live',[$f->lecturer->user_id,$f->lecturer->room->streams_name])}}" @endif data-lecturer="{{$f->lecturer_id}}" class="thumb{{$f->id}} @if($f->id == 1) curr @endif">
                            <div><em></em><span><img src="{{$f->small}}"></span></div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--轮播图结束-->
        <div class="container js_list">
            <ul>
                @foreach($lives as $k => $live)
                    <a @if($k < 7) href="{{route('live',[$live->user_id,$live->room->streams_name])}}">
                        <li>
                            <img src="{{$live->user->thumb}}" class="img-circle" style="width: 100px;height: 100px" alt="">
                            <p>{{$live->user->name}}</p>
                            <div title="{{$live->user->sign ? : '暂无签名'}}">{{$live->user->sign ? : '暂无签名'}}</div>
                        </li>
                    </a @endif>
                @endforeach
            </ul>
        </div>

        <div class="container view">
            <h3>
                <span>牛人观点</span>
            </h3>
            <div class="left">
                <div class="title">
                    <ul>
                        @foreach($types as $k => $type)
                        <li class="@if($k === 0)no_border @endif">{{$type->name}}</li>
                        @endforeach
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="content">
                    @foreach($types as  $k => $type)
                        <ul  style="@if($k === 0) display:block @endif"  >
                            @foreach($type->articles as $kk => $v)
                                @if($kk < 10)
                                <li style="list-style: square">
                                    <a href="{{route('details',$v->id)}}">
                                        <span class="content_title">{!! $v->contents !!}</span>
                                    </a>
                                    <span class="pull-right">{{date('Y.m.d',strtotime($v->ctime))}}</span>
                                    <div style="clear: both"></div>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    @endforeach

                </div>
            </div>
            <div class="right">
                <div class="title" style="border-bottom: 2px solid transparent">
                    12小时点击排行 <span class="pull-right" style="color: #999;font-weight: 500;font-size: 14px"><a href="{{route('master.view')}}" target="_blank">查看更多></a></span>
                </div>
                <div class="content">
                    <ul>
                        @foreach($articles as $k => $a)
                            <li>
                                <a href="{{route('details',$a->id)}}">
                                        <span class="content_title">{{$k + 1}}、{!! $a->title !!}</span>
                                </a>
                                <span class="pull-right">{{date('Y.m.d',strtotime($v->ctime))}}</span>
                                <div style="clear: both"></div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <style>
            .container.dk .left ul{
                text-align: center;
                background: #fff;
                padding: 15px;
            }
            .container.dk ul li{
                width: 33%;
                float: left;
                margin-bottom: 5px;
            }
            .container.dk ul li .nickname{
                width: 90%;
                margin: 0 auto;
                overflow: hidden;
                text-overflow:ellipsis;
                white-space: nowrap;
                text-align: center;
                margin-top: 5px;
                margin-bottom: 15px;
            }
            .container.dk .right .content{
                padding: 15px;
                background: #fff;
            }
        </style>
        <div class="container dk" style="padding: 0">
            <div class="left" style="width: 35%;float: left">
                <h3 style="background: #f2f2f2;text-align: left"><span>大咖秀</span> </h3>
                <ul>
                    @foreach($lives as $l)
                        <a href="{{route('live',[$l->user_id,$l->room->streams_name])}}">
                    <li>
                        @if(empty($l->room->thumb))
                            <img src="/homestyle/images/p1.png" width="100" height="100" class="img-circle">
                        @else
                            <img src="{{$l->room->thumb}}" width="100" height="100"  class="img-circle">
                        @endif
                        <p class="nickname">
                            @if(empty($l->user->name))
                               讲师：{{$l->user->oauth->nickname}}
                            @else
                                讲师：{{$l->user->name}}
                            @endif
                        </p>
                    </li>
                        </a>
                    @endforeach
                    <div style="clear: both"></div>
                </ul>
            </div>
            <div class="right" style="width: 63%;float: right">
                <h3><span>精选视频</span> </h3>
                <div class="content">
                    <ul>
                        @foreach($back_live as $k => $back)
                            @if(!empty($back->user))
                                @if($k < 6)
                                <li>
                                    <a href="{{route('back.live.details',$back->id)}}">
                                        <div class="liveimg">
                                            <img src="http://{{$back->thumb}}" width="224" height="121">
                                            <span class="tagtxt3">
                                    </span>
                                        </div>
                                        <div class="livetxt">
                                            <p  class="livetit">{{subtext($back->title,10)}}</p>
                                            <p  class="livetec">
                                                <span class="pull-left">讲师：@if(empty($back->user->name)) {{$back->user->oauth->nickname}} @else {{$back->user->name}} @endif</span>
                                                <span class="pull-right text-right" style="color:#de4c44;">
                                        </span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                @endif
                            @endif
                        @endforeach
                        <div style="clear: both"></div>
                    </ul>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <h3 style="margin-top:30px;">
                    <span style="margin-top:-3px;">
                        <img src="/homestyle/images/icon-3.png" width="34" height="34">
                    </span>
                    <span>直播回放</span>
                </h3>
                <div class="biglive">
                    <ul>
                        @foreach($back_live as $back)
                            @if(!empty($back->user))
                        <li>
                            <a href="{{route('back.live.details',$back->id)}}">
                                <div class="liveimg">
                                    <img src="http://{{$back->thumb}}" width="224" height="121">
                                    <span class="tagtxt3">
                                        <i class="glyphicon glyphicon-play-circle"></i>
                                        回放
                                    </span>
                                </div>
                                <div class="livetxt">
                                    <p  class="livetit">{{subtext($back->title,10)}}</p>
                                    <p  class="livetec">
                                        <span class="pull-left">讲师：@if(empty($back->user->name)) {{$back->user->oauth->nickname}} @else {{$back->user->name}} @endif</span>
                                        <span class="pull-right text-right" style="color:#de4c44;">
                                            <i class="glyphicon  glyphicon-heart"></i>
                                            {{$back->count}}
                                        </span>
                                    </p>
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
    @stop

@section('js')
    <script type="text/javascript">
        $(".main-slider").bind("mouseover", function(){
            $(".joinRoomBox").show();
        }).bind("mouseout",function(){
            $(".joinRoomBox").hide();
        });
        $(".joinRoomBox").bind("mouseover", function(){
            $(this).css("background", "#dd0000");
        }).bind("mouseout",function(){
            $(this).css("background", "#ff4436");
        });

        $('.thumbs li').click(function(){
            $('.slide-item, .thumbs li').removeClass('curr');
            $(this).addClass('curr');
            var redirect = $(this).data('url');
            $('.joinRoomBox a').attr('href',redirect);
            var lecturer_id = $(this).data('lecturer');
            var url = '{{route('cut.live')}}';
            $('#main').attr('src',url+'?lecturer_id='+lecturer_id);

        })

        $(".title ul li").hover(function () {
            var index = $(this).index();
            $(this).addClass('no_border').siblings().removeClass('no_border');
            $(".content ul").eq(index).show().siblings().hide();
        })
    </script>
    @stop