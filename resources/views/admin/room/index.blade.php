@extends('admin.layouts.application')
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
                        <a href="{{route('room.video.model')}}">
                            <button type="button" class="am-btn am-btn-info"><span class="am-icon-image"></span> 相册模式</button>
                        </a>
                    </div>
                </div>
            </div>
            <form method="get">
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-form-group">
                    <select data-am-selected="{btnSize: 'sm'}" name="status">
                        <option value="-1">房间状态</option>
                        <option value="1" @if(Request::input('status') == 1) selected @endif>正常</option>
                        <option value="2" @if(Request::input('status') == 2) selected @endif>关闭</option>
                    </select>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm am-u-md-8">
                    <input name="room_name" value="{{Request::input('room_name')}}" type="text" class="am-form-field" />
                    <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default" type="submit">搜索</button>
                    </span>
                </div>
            </div>
            </form>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-type">房间名称</th>
                            <th class="table-title">所属者</th>
                            <th class="table-title">流名称</th>
                            <th class="table-title">直播状态</th>
                            <th class="table-title">流状态</th>
                            <th class="table-type">房间状态</th>
                            <th class="table-date am-hide-sm-only">创建日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($room as $r)
                            @if(!empty($r->lecturer->user))
                        <tr>
                            <td><a href="#">{{$r->room_name}}</a></td>
                            @if(empty($r->lecturer_id))
                            <td><a href="javascript:void (0);">暂无</a></td>
                                @else
                                <td><a href="{{route('lecturer.edit',$r->lecturer_id)}}" target="_blank">{{$r->lecturer->user->name}}</a></td>
                            @endif
                            <td>{{$r->streams_name}}</td>
                            <td>
                                @if(!empty(liveStatus($r->streams_name)['status']))
                                <span class="am-badge am-badge-danger am-round">暂未开播</span>
                                @elseif(getStream($r->streams_name)['disabledTill'] == 0)
                                <span class="am-badge am-badge-success am-round">正在直播</span>
                                        @else
                                    <span class="am-badge am-badge-warning am-round">已禁播</span>
                                    @endif
                            </td>
                            <td>
                                @if(getStream($r->streams_name)['disabledTill'] == 0)
                                    <span style="margin-left:15px;" class="am-icon-check streams_status" data-name="{{$r->streams_name}}"></span>
                                @else
                                    <span style="margin-left:15px;" class="am-icon-close streams_status" data-name="{{$r->streams_name}}"></span>
                                @endif
                            </td>
                            <td class="am-hide-sm-only">
                                @if($r->status == 3)
                                <span class="am-badge am-badge-danger am-radius">关闭</span>
                                @else
                                <span class="am-badge am-badge-success am-radius">正常</span>
                                    @endif
                            </td>
                            <td class="am-hide-sm-only">{{$r->created_time}}</td>
                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a href="{{route('room.edit',$r->id)}}" target="_blank">
                                            <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                <span class="am-icon-pencil-square-o"></span> 详情</button>
                                        </a>
                                        <a href="javascript:void (0);">
                                            @if($r->status == 1)
                                                <button data-id="{{$r->id}}" type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only room_status">
                                                    <span class="am-icon-close"></span> 关闭</button>
                                                @elseif($r->status == 2)
                                                <button data-id="{{$r->id}}" type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only room_status">
                                                    <span class="am-icon-check"></span> 开启</button>
                                                @endif
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$room->count()}} 条记录
                        <div class="am-fr">
                            {!! $room->appends(Request::all())->links() !!}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>

        </div>
    </div>
    @stop

@section('js')
    <script>
        $(function(){
            $('.streams_status').click(function(){
                var _this = $(this);
                var name = $(this).data('name');
                layer.confirm('是否要操作流状态？', {
                    btn: ['确认','取消'] ,
                    title: false
                }, function(){
                    $.ajax({
                        type: "post",
                        url: "{{route('room.stream_status')}}",
                        data: {name: name},
                        success: function (data) {
                            if(data.status == false){
                                layer.msg(data.msg, {icon: 2});
                                return false;
                            }
                            if (_this.hasClass('am-icon-close')) {
                                _this.removeClass('am-icon-close').addClass('am-icon-check');
                                layer.msg(data.msg, {icon: 1});
                                return false;
                            } else {
                                _this.removeClass('am-icon-check').addClass('am-icon-close');
                                layer.msg(data.msg, {icon: 1});
                                return false;
                            }
                        },error: function(){
                            layer.msg('操作失败！');
                        }
                    });
                });
            });
            $('.room_status').click(function(){
                var _this = $(this);
                var room_id = $(this).data('id');
                layer.confirm('是否要改变房间状态？', {
                    btn: ['确认','取消'] ,
                    title: false
                }, function(){
                    $.ajax({
                        type: "post",
                        url: "{{route('room.close')}}",
                        data: {room_id: room_id},
                        success: function (data) {
                            if(data.status == false){
                                layer.msg(data.msg, {icon: 2});
                                return false;
                            }
                            layer.msg(data.msg, {icon: 1});
                            setTimeout(function () {
                                location.href = "{{route('room')}}";
                            }, 1000);
                            return false;

                        },error: function(){
                            layer.msg('操作失败！');
                        }
                    });
                }
            )
            })
        })
    </script>
    @stop