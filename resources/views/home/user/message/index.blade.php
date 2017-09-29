@extends('home.layout.app')
@section('css')
    {{--<link rel="stylesheet" href="/jpage/css/jPages.css" >--}}
    {{--<link rel="stylesheet" href="/jpage/css/animate.css">--}}
    <link href="{{asset('homestyle/css/page.css')}}" rel="stylesheet" type="text/css">
    @stop
@section('content')
    <div class="container user">
        <div class="row">
        @include('home.user.menu')
            <!--右侧-->
            <div class="pull-right userright">
                <div class="record">
                    <div class="recording">
                        <div style=" width:100%; height:50px;border-bottom:#ddd 1px solid;">
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的消息</div>
                        </div>
                        <div class="clear"></div>
                        <div class="message">
                            <ul id="itemContainer">
                                @foreach($message as $m)
                                <li>
                                    <a href="{{route('message.show',$m->id)}}">
                                        <div class="pull-left">
                                            <div class="mymessage">
                                                @if($m->type == 1)
                                                    <img class="img-circle" src="{{$m->user->thumb}}" width="50" height="50">
                                                    @else
                                                    <img class="img-circle" src="{{asset('homestyle/images/logo1.png')}}" width="50" height="50">
                                                @endif
                                            </div>
                                            <div class="mytxt" @if($m->is_read == 1) style="color:#DB8258;" @endif>
                                                @if($m->type == 1)
                                                <p>付费提问</p>
                                                    @elseif($m->type == 2)
                                                    <p>系统消息</p>
                                                @endif
                                                <p class="mydetail">{{$m->title}}</p>
                                            </div>
                                        </div>
                                        @if($m->status == 2)
                                            <div class="pull-right" style="margin-left: 20px;"><span class="glyphicon glyphicon-ok btn-success" aria-hidden="true"></span> </div>
                                        @endif
                                        <div class="pull-right"> <span >{{$m->created_time}}</span> </div>

                                    </a>
                                </li>
                                <div class="clear"></div>
                                    @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:5px;"></div>
                <div aria-label="Page navigation">
                    <div class="holder"></div>
                </div>
            </div>

            <!--右侧结束-->
        </div>
    </div>
    <div style="height:60px;"></div>
@stop

@section('js')
    <script type="text/javascript" src="/jpage/js/tabifier.js"></script>
    <script src="/jpage/js/jPages.js"></script>
    <script type="text/javascript" src="/jpage/js/highlight.pack.js"></script>
    <script>
        /* when document is ready */
        $(function() {
            /* initiate plugin */
            $("div .holder").jPages({
                containerID: "itemContainer",
                previous : "上一页",
                next : "下一页",
                perPage : 16,
            });
        });
    </script>
    @stop