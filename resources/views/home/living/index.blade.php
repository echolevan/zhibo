@extends('home.layout.app')

@section('css')
    <link href="{{asset('/homestyle/css/second.css')}}" rel="stylesheet" type="text/css">
    @stop
@section('content')
<div class="container">
    <div class="row">
        <div class="liveleft">
            <div class="live-title-bg">
                <div class="live-title-img">
                    <i class=" live-title-icon"></i><span class="live-title-txt">正在直播</span>
                </div>
            </div>
            <div class="live-con">
                <div class="live-con-title">直播类型</div>
                <div class=" clear"></div>
                <div class="type-box">
                    <ul>
                        <li class="active"> <a href="?type=1">股票</a></li>
                        <li><a href="?type=2">期货</a></li>
                        <li><a href="?type=3">黄金</a></li>
                        <li><a href="?type=4">外汇</a></li>
                    </ul>
                </div>
            </div>
            <div class=" clear"></div>
            <div style="height:20px;"></div>
        </div>
        <div class="liveright">
            <div class="liveright-title">全部直播</div>
            <div class="biglive">
                <ul>
                    @foreach($living as $l)
                        @if(empty(liveStatus($l->streams_name)['status']))
                    <li>
                        <a href="{{route('live',[$l->user_id,$l->streams_name])}}" target="_blank">
                            <div class="liveimg">
                                <img src="{{photoUrl($l->streams_name)}}" width="224" height="121">
                            </div>
                            <div class="livetxt">
                                <p  class="livetit">{{$l->room_name}}</p>
                                <p  class="livetec">
                                    <span class="pull-left">讲师：{{$l->name}}</span>
                                    <span class="pull-right text-right" style="color:#de4c44;">
                                        <i class="glyphicon  glyphicon-heart"></i>
                                        {{App\Models\Follow::where('user_id',$l->user_id)->count()}}
                                    </span>
                                </p>
                            </div>
                        </a>
                    </li>
                        @endif
                        @endforeach
                </ul>

            </div>
            <div class="clear"></div>
            <div aria-label="Page navigation">
                <ul class="pagination">
                    {!! $living->appends(Request::all())->links() !!}
                </ul>
            </div>
        </div>
    </div>
</div>
    @stop
@section('js')
    <script>
        $(function(){
            $('.type-box ul li').click(function(){
                $('.type-box ul li').removeClass('active');
                $(this).addClass('active');
            })
        })
    </script>
    @stop