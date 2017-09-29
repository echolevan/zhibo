@extends('admin.layouts.application')
@section('css')
    <link href="{{asset('video/video-js.css')}}" rel="stylesheet">

    <!-- If you'd like to support IE8 -->
    <script src="{{asset('video/videojs-ie8.min.js')}}"></script>
@stop
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">房间详情</strong> / <small>Room Info</small></div>
        </div>

        <hr>

        <div class="am-g ">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
                    <ul class="am-tabs-nav am-nav am-nav-tabs">
                        <li class="am-active"><a href="#tab1">房间详情</a></li>
                        <li><a href="#tab2">视频流详情</a></li>
                    </ul>

                    <div class="am-tabs-bd">
                        <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                            <form  class="am-form am-form-horizontal">
                                <input type="hidden" name="id" value="{{$room->id}}" />
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        房间名称
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input name="room_name" type="text"  value="{{$room->room_name}}" required/>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        房间分配
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">



                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        房间人数限制
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <input name="number" type="number"  value="{{$room->number}}" required/>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        简介
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <textarea class="desc" type="text">{{$room->desc}}</textarea>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        公告
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <textarea class="notice" type="text">{{$room->notice}}</textarea>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        弹幕开关
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <label class="am-checkbox am-success">
                                            <input name="barrage" type="checkbox"
                                                   @if($room->barrage == 1)
                                                   checked="checked"
                                                   @endif
                                                   value="1" data-am-ucheck="" class="am-ucheck-checkbox">
                                            <span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i class="am-icon-checked"></i></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        发言开关
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                        <label class="am-checkbox am-success">
                                            <input name="speak" type="checkbox"
                                                   @if($room->speak == 1)
                                                   checked="checked"
                                                   @endif
                                                   value="1" data-am-ucheck="" class="am-ucheck-checkbox">
                                            <span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i class="am-icon-checked"></i></span>
                                        </label>
                                    </div>
                                </div>

                                {{--<div class="am-g am-margin-top">--}}
                                    {{--<div class="am-u-sm-4 am-u-md-2 am-text-right">--}}
                                        {{--抽奖开关--}}
                                    {{--</div>--}}
                                    {{--<div class="am-u-sm-8 am-u-md-4 am-u-end col-end">--}}
                                        {{--<label class="am-checkbox am-success">--}}
                                            {{--<input name="luck" type="checkbox"--}}
                                                   {{--@if($room->luck == 1)--}}
                                                   {{--checked="checked"--}}
                                                   {{--@endif--}}
                                                   {{--value="1" data-am-ucheck="" class="am-ucheck-checkbox">--}}
                                            {{--<span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i class="am-icon-checked"></i></span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <hr data-am-widget="divider" style="" class="am-divider am-divider-dotted" />
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label"></label>
                                    <button class="am-btn am-btn-secondary edit_room" type="button">修改</button>
                                </div>
                            </form>
                        </div>
                        <div class="am-tab-panel am-fade" id="tab2">
                            <form  class="am-form am-form-horizontal">
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        推流地址
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-9 am-u-end col-end">
                                        <small>{{publishUrl($room->streams_name)}}</small>
                                    </div>
                                </div>
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        直播地址
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-6 am-u-end col-end">
                                        <small>{{playUrl($room->streams_name)}}</small>
                                    </div>
                                </div>
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        HLS直播地址
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-6 am-u-end col-end">
                                        <small>{{hlsUrl($room->streams_name)}}</small>
                                    </div>
                                </div>
                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        HDL直播地址
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-6 am-u-end col-end">
                                        <small>{{hdlUrl($room->streams_name)}}</small>
                                    </div>
                                </div>

                                <div class="am-g am-margin-top">
                                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                                        直播状态
                                    </div>
                                    <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                                        @if(!empty(liveStatus($room->streams_name)['status']))
                                            <span class="am-badge am-badge-danger am-round">暂未开播</span>
                                        @elseif(getStream($room->streams_name)['disabledTill'] == 0)
                                            <span class="am-badge am-badge-success am-round">正在直播</span>
                                            <hr>
                                            <video id="my-video" class="video-js" controls preload="auto" width="500" height="300"
                                                   poster="{{photoUrl($room->streams_name)}}"
                                                   data-setup="{}">
                                                <source src="{{playUrl($room->streams_name)}}" type="rtmp/flv">
                                                <source src="{{hlsUrl($room->streams_name)}}" type='application/x-mpegURL'>
                                            </video>
                                        @else
                                            <span class="am-badge am-badge-warning am-round">已禁播</span>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('video/video.js')}}"></script>
    <script>
        $(function(){
            $(".am-gallery-item").hover(function () {
                $('.file-panel').fadeIn(300);
            }, function () {
                $('.file-panel').fadeOut(300);
            });

            $('.edit_room').click(function(){
                var room_name = $('input[name=room_name]').val();
                var lecturer_id = $(".lecturer option:selected").val()
                var desc = $('.desc').val();
                var notice = $('.notice').val();
                var thumb = $('input[name=thumb]').val();
                var number = $('input[name=number]').val();
               // var luck =  $('input[name=luck]').is(':checked');
                var barrage =  $('input[name=barrage]').is(':checked');
                var speak =  $('input[name=speak]').is(':checked');
//                if(luck == true){
//                    luck = 1;
//                }else{
//                    luck = 2;
//                }
                if(barrage == true){
                    barrage = 1;
                }else{
                    barrage = 2;
                }
                if(speak == true){
                    speak = 1;
                }else{
                    speak = 2;
                }
                var data = {
                    id: $('input[name=id]').val(),
                    room_name: room_name,
                    lecturer_id: lecturer_id,
                    desc: desc,
                    notice: notice,
                    thumb: thumb,
                    number: number,
                   // luck: luck,
                    barrage: barrage,
                    speak: speak
                };
                $.ajax({
                    type: 'post',
                    url: '{{route('room.update')}}',
                    data: data,
                    success: function(data){
                        if(data.status == false){
                            layer.msg(data.msg);
                            return false;
                        }
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function () {
                            location.href = "{{route('room')}}";
                        }, 2000);
                        return false;
                    },error: function(){
                        layer.msg('修改失败！');
                        return false;
                    }
                })
            })
        })
    </script>
@stop
