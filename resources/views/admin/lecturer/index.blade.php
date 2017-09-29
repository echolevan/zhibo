@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">讲师列表</strong> / <small>Lecturer List</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('lecturer.create')}}">
                            <button type="button" class="am-btn am-btn-success"><span class="am-icon-plus"></span> 新增</button>
                        </a>

                    </div>
                </div>
            </div>
            <form method="get">
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-form-group">
                    <select data-am-selected="{btnSize: 'sm'}" name="status">
                        <option value="-1">讲师状态</option>
                        <option value="1" @if(Request::input('status') == 1) selected @endif>正常</option>
                        <option value="2" @if(Request::input('status') == 2) selected @endif>冻结</option>
                    </select>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm am-u-md-8">
                    <input name="name" value="{{Request::input('name')}}" type="text" class="am-form-field" placeholder="讲师昵称" />
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
                            <th class="table-title">昵称</th>
                            <th class="table-title">直播间</th>
                            <th class="table-type">讲师排序</th>
                            <th class="table-title">资产</th>
                            <th class="table-title">状态</th>
                            <th class="table-date am-hide-sm-only">申请日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lecturer as $l)

                        <tr>
                            <td><a href="{{route('lecturer.edit',$l->id)}}" target="_blank">
                                    @if(empty($l->name))
                                        {{oauth_name($l->oauth_id)}}
                                        @else
                                        {{$l->name}}
                                        @endif

                                </a></td>
                            <td>
                                @if(!empty($l->lecturer_id))
                                  <a href="{{route('room.edit',$l->room_id)}}" target="_blank"><span class="am-badge am-badge-success">查看</span></a>
                                    @else
                                    <span class="am-badge am-badge-warning">暂无直播间</span>
                                    @endif
                            </td>
                            <td>{{$l->sort}}</td>
                            <td class="am-hide-sm-only">{{$l->award}}</td>
                            <td>
                                @if($l->user_status == 1)
                                    <span class="am-badge am-badge-success am-radius">正常</span>
                                    @elseif($l->user_status == 2)
                                    <span class="am-badge am-badge-warning am-radius">冻结</span>
                                    @else
                                    <span class="am-badge am-badge-danger am-radius">永久封号</span>
                                    @endif
                            </td>
                            <td class="am-hide-sm-only">{{$l->created_time}}</td>
                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a href="{{route('lecturer.check.info',$l->id)}}" target="_blank">
                                            <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                <span class="am-icon-clone"></span>
                                                审核详情</button>
                                        </a>
                                        <a href="{{route('lecturer.edit',$l->id)}}" target="_blank">
                                            <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                <span class="am-icon-pencil-square-o"></span>
                                                详情</button>
                                        </a>
                                        <a href="javascript:void (0);">
                                            @if($l->user_status == 1)
                                            <button type="button" data-id="{{$l->user_id}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only lecturer_status">
                                                <span class="am-icon-close"></span>
                                                冻结</button>
                                            @elseif($l->user_status == 2)
                                            <button type="button" data-id="{{$l->user_id}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only lecturer_status">
                                                <span class="am-icon-check"></span>
                                                恢复</button>
                                                @endif
                                        </a>

                                    </div>
                                </div>
                            </td>
                        </tr>

                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$lecturer->count()}} 条记录
                        <div class="am-fr">
                            {!! $lecturer->appends(Request::all())->links() !!}
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
            $('.lecturer_status').click(function(){
                var _this = $(this);
                var user_id = $(this).data('id');
                layer.confirm('是否要改变讲师状态？', {
                            btn: ['确认','取消'] ,
                            title: false
                        }, function(){
                            $.ajax({
                                type: "post",
                                url: "{{route('lecturer.changeStatus')}}",
                                data: {user_id: user_id},
                                success: function (data) {
                                    if(data.status == false){
                                        layer.msg(data.msg, {icon: 2});
                                        return false;
                                    }
                                    layer.msg(data.msg, {icon: 1});
                                    setTimeout(function () {
                                        location.href = "{{route('lecturer')}}";
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