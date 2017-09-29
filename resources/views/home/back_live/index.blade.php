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
                        <i class=" live-title-icon"></i><span class="live-title-txt">直播回看</span>
                    </div>
                </div>
                <div class="live-con">
                    <div class="live-con-title">回看类型</div>
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
                <div class="clear"></div>
                <div class="tab-content">
                    <div class="biglive tab-pane active" id="home">
                        <ul>
                            @foreach($back as $b)
                                @if(!empty($b->user))
                            <li> <a href="{{route('back.live.details',$b->id)}}">
                                    <div class="liveimg"> <img src="http://{{$b->thumb}}" width="224" height="121"><span class="live-right-tag"></span></div>
                                    <div class="livetxt">
                                        <p  class="livetit">{{subtext($b->title,10)}}</p>
                                        <p  class="livetec"> <span class="pull-left">讲师：{{$b->user->name}}</span> <span class="pull-right text-right" style="color:#de4c44;">
                                                <i class="glyphicon  glyphicon-heart"></i>{{$b->count}}</span> </p>
                                    </div>
                                </a> </li>
                                @endif
                                @endforeach
                        </ul>

                    </div>
                    <div class="clear"></div>
                    <div aria-label="Page navigation">
                        <ul class="pagination">
                            {!! $back->appends(Request::all())->links() !!}
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>
@stop
@section('js')
    {{--<script src="{{asset('homestyle/js/bootstrap-tab.js')}}"></script>--}}
    <script>
        $(function(){
            $('.type-box ul li').click(function(){
                $('.type-box ul li').removeClass('active');
                $(this).addClass('active');
            })
        })
    </script>
@stop