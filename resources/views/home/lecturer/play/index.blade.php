@extends('home.layout.app')

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
                        <div style="width:100%; height:50px;border-bottom:#ddd 1px solid;">
                            <div class="recordtit"><span style="width:5px; height:35px; display:block; float:left; background:#ff4436;"></span> 开播停播</div>
                        </div>
                        <div class="clear"></div>
                        @if(empty($userinfo->lecturer->room))
                            <div class="rightcon">
                                <div class="collapse" >
                                    <div class="well text-success">
                                        暂未分配房间，请联系客服，请联系客服！
                                    </div>
                                </div>
                            </div>
                        @else
                            @if($userinfo->lecturer->room->status == 2)
                                <div class="rightcon" style="margin-top: 10px;">
                                    <div class="collapse" >
                                        <div class="well text-success">
                                            你的房间已被关闭，请联系客服！
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="tab-content">
                                    <div class="message-1">
                                        <div class="viewtext">
                                            <div class="postview-1">
                                                <div class="re-txt mt20">
                                                    <label class="relable">房间ID：</label>
                                                    <span class="respan">{{$userinfo->lecturer->room->streams_name}}</span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">房间标题：</label>
                                                    <span class="respan">{{$userinfo->lecturer->room->room_name}}</span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">人数限制：</label>
                                                    <span class="respan">{{$userinfo->lecturer->room->number}}人 （允许最大人数！）</span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">弹幕：</label>
                                            <span class="respan">
                                                @if($userinfo->lecturer->room->barrage == 1)
                                                    已开启
                                                @else
                                                    关闭
                                                @endif
                                            </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">发言：</label>
                                            <span class="respan">
                                                @if($userinfo->lecturer->room->speak == 1)
                                                    已开启
                                                @else
                                                    关闭
                                                @endif
                                            </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">推流地址：</label>
                                            <span class="respan">
                                                <input type="text" id="getpublishUrl" class="form-control re-input-txt" value="{{publishUrl($userinfo->lecturer->room->streams_name)}}" />
                                                <button style="float:right;" type="button" class="btn rebtn-border getpublishUrl">获取</button>
                                            </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable"></label>
                                                    @if(getStream($userinfo->lecturer->room->streams_name)['disabledTill'] == 0)
                                                        <button type="button" class="btn viewbtn" disabled>开始直播</button>
                                                        <label class="relable"></label>&nbsp;&nbsp;&nbsp;
                                                        <button type="button" class="btn viewbtn stop" data-name="{{$userinfo->lecturer->room->streams_name}}" style="background-color:#FF8B23;">结束直播</button>
                                                        @else
                                                        <button type="button" class="btn viewbtn check" data-name="{{$userinfo->lecturer->room->streams_name}}">开始直播</button>
                                                        <label class="relable"></label>&nbsp;&nbsp;&nbsp;
                                                        <button type="button" class="btn viewbtn" style="background-color:#FF8B23;" disabled>结束直播</button>
                                                        @endif
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                            @endif
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:225px;"></div>

            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
@section('js')
    <script>
        $(".getpublishUrl").on('click',function(){
            var e=document.getElementById("getpublishUrl");
            e.select();
            document.execCommand("Copy");
            layer.msg('复制成功！', {icon: 1});
        });

        $(function(){
            $('.check').click(function(){
                var _this = $(this);
                var name = $(this).data('name');
                layer.confirm('是否要开启直播？', {
                    btn: ['确认','取消'] ,
                    title: false
                }, function(){
                    $.ajax({
                        type: "post",
                        url: "{{route('play.stream_status')}}",
                        data: {name: name},
                        success: function (data) {
                            if(data.status == false){
                                layer.msg(data.msg, {icon: 2});
                                return false;
                            }
                            layer.msg('开启成功！', {icon: 1});
                            {{session()->put('start_time',time())}}
                            setTimeout(function () {
                                window.location.reload()
                            }, 1000);
                            return false;
                        },error: function(){
                            layer.msg('操作失败！');
                        }
                    });
                });
            });

            $('.stop').click(function(){
                var name = $(this).data('name');
                layer.confirm('是否要保存当前录像？', {
                    btn: ['保存','不保存'] //按钮
                }, function(){
                    layer.prompt({title: '请为该视频命名！', formType: 2}, function(val, index){
                        if(val == ''){
                            layer.msg('请填写视频名称！')
                            return false;
                        }
                        $.ajax({
                            type: 'post',
                            url: '{{route('live.history')}}',
                            data: {name: name,title: val},
                            success: function (data) {
                                if(data.status == false){
                                    layer.msg(data.msg, {icon: 2});
                                    return false;
                                }
                                layer.msg(data.msg, {icon: 1});
                                layer.close(index);
                                setTimeout(function () {
                                    window.location.reload()
                                }, 1000);
                                return false;
                            },error: function(){
                                layer.msg('操作失败！');
                            }
                        })

                    });
                }, function(){
                    $.ajax({
                        type: "post",
                        url: "{{route('play.stream_status')}}",
                        data: {name: name},
                        success: function (data) {
                            if(data.status == false){
                                layer.msg(data.msg, {icon: 2});
                                return false;
                            }
                            layer.msg('已停止！', {icon: 1});
                            setTimeout(function () {
                                window.location.reload()
                            }, 1000);
                            return false;
                        },error: function(){
                            layer.msg('操作失败！');
                        }
                    });
                });
            })
        })
    </script>
@stop