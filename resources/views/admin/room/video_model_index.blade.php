@extends('admin.layouts.application')
@section('css')
    <link href="{{asset('video/video-js.css')}}" rel="stylesheet">

    <!-- If you'd like to support IE8 -->
    <script src="{{asset('video/videojs-ie8.min.js')}}"></script>
@stop
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">房间列表</strong> / <small>Room</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('room.create')}}">
                            <button type="button" class="am-btn am-btn-success"><span class="am-icon-plus"></span> 新增</button>
                        </a>
                        <a href="{{route('room')}}">
                            <button type="button" class="am-btn am-btn-info"><span class="am-icon-navicon"></span> 列表模式</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <ul class="am-avg-sm-2 am-avg-md-4 am-avg-lg-5 am-margin gallery-list">
                    @foreach($room as $r)
                    <li>
                        <a href="#">
                            <video id="my-video" class="video-js" controls preload="auto" width="300" height="170"
                                   @if(empty(liveStatus($r->streams_name)['status']))
                                   poster="{{photoUrl($r->streams_name)}}"
                                   @endif
                                   data-setup="{}">
                                <source src="{{playUrl($r->streams_name)}}" type="rtmp/flv">
                                <source src="{{hlsUrl($r->streams_name)}}" type='application/x-mpegURL'>
                            </video>
                                <div class="gallery-title">{{$r->room_name}}</div>
                            <div class="gallery-desc">{{$r->created_time}}</div>
                        </a>
                    </li>
                        @endforeach
                </ul>

                <div class="am-cf">
                    共 {{$room->count()}} 条记录
                    <div class="am-fr">
                        {!! $room->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop
@section('js')
    <script src="{{asset('video/video.js')}}"></script>
@stop