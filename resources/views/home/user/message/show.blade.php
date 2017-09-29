@extends('home.layout.app')
@section('content')
    <div class="container user">
        <div class="row">
            @include('home.user.menu')
                    <!--右侧-->
            <div class="pull-right userright" style="background:#f2f2f5; border:#ddd 1px solid; padding:0px;">
                <div class="official">
                    <div class="off-tit">
                        <span class="pull-left"><a href="{{route('user.message')}}" class="back"><img src="/homestyle/images/back.png" width="16" height="16"></a></span>
                        <div class="offname">
                            @if($message->type == 2)
                            <strong>系统消息</strong>
                                @else
                                向<strong>{{$message->tuUser->name}}的提问</strong>
                                @endif
                        </div>
                    </div>
                    <div class="talk_recordbox">
                        <div class="user">
                            @if($message->type == 1)
                                <img src="{{$message->user->thumb}}" class="img-circle" width="50" height="50">
                            @else
                                <img class="img-circle" src="{{asset('homestyle/images/logo1.png')}}" width="50" height="50">
                            @endif
                        </div>
                        <div class="talk_recordtextbg"> &nbsp;</div>
                        @if($message->type == 2)
                        <div class="talk_recordtext">{{$message->reply}}</div>
                            @elseif($message->type == 1)
                            <div class="talk_recordtext">{{$message->title}}</div>
                            @endif
                    </div>
                    @if($message->type == 2)
                        <div class="Sendtime">
                            <span>以上为系统消息</span>
                        </div>
                    @elseif($message->type == 1)
                        <div class="Sendtime">
                            <span>{{$message->created_time}}</span>
                        </div>
                        @endif
                    @if($message->type == 1 && $message->status == 2)
                    <div class="talk_recordboxme">
                        <div class="user"><img src="{{$message->tuUser->thumb}}" class="img-circle" width="50" height="50"></div>
                        <div class="talk_recordtextbg"> &nbsp;</div>
                        <div class="talk_recordtext">{{$message->reply}}</div>
                    </div>
                    <div class="Sendtime">
                        <span>以上为历史记录</span>
                    </div>
                        @endif
                </div>
            </div>

            <!--右侧结束-->
        </div>
    </div>
    <div style="height:60px;"></div>
@stop