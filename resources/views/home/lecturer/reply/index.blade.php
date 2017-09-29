@extends('home.layout.app')
@section('css')
    <link rel="stylesheet" href="/jpage/css/jPages.css" >
    <link rel="stylesheet" href="/jpage/css/animate.css">
@stop
@section('content')
    <div class="container user">
        <div class="row">
            <!--左侧-->
            @include('home.lecturer.layout.left')
                    <!--左侧结束-->
            <!--右侧-->
            <div class="pull-right userright">
                <div class="record">
                    <div class="recording">
                        <div style=" width:100%; height:50px;border-bottom:#ddd 1px solid;">
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>处理提问</div>

                        </div>
                        <div class="clear"></div>
                        <div class="tab-content">
                            <div class="message">
                                <ul>
                                    @foreach($message as $m)
                                        @if(!empty($m->user))
                                    <li>
                                        <a href="{{route('lecturer.reply.show',$m->id)}}">
                                        <div class="pull-left">
                                            <div class="mymessage">
                                                @if(empty($m->user->thumb))
                                                    <img class="img-circle" src="{{$m->user->oauth->avatar_url}}" width="50" height="50">
                                                @else
                                                    <img class="img-circle" src="{{$m->user->thumb}}" width="50" height="50">
                                                @endif
                                            </div>
                                            <div class="mytxt">
                                                @if($m->reply_price != 0)
                                                <p @if($m->is_read == 1) style="color:#ea5739;" @endif>付费问题 <span style="color:#ea5739;"><img src="/homestyle/images/gold.png" width="12" height="14">￥{{$m->reply_price}}</span></p>
                                                    @else
                                                    <p>免费问题</p>
                                                @endif
                                                <p class="mydetail">{{$m->title}}</p>
                                            </div>
                                        </div>
                                            @if($m->status == 2)
                                            <div class="pull-right" style="margin-left: 20px;"><span class="glyphicon glyphicon-ok btn-success" aria-hidden="true"></span> </div>
                                            @endif
                                            <div class="pull-right"> <span >{{date('Y年m月d日',strtotime($m->created_time))}}</span> </div>
                                            </a>
                                    </li>
                                    <div class="clear"></div>
                                        @endif
                                        @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:5px;"></div>
                <div aria-label="Page navigation">
                    <ul class="pagination">
                        @if($message->count() > 10)
                            <div class="holder"></div>
                        @endif
                    </ul>
                </div>
            </div>
            <!--右侧结束-->
        </div>
    </div>

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
                previous : "←",
                next : "→",
                perPage : 10,
            });
        });
    </script>
    @stop