@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">用户管理</strong> /
                <small>...</small>
            </div>
        </div>
        <hr>
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('admin.user_create')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span>
                                新增用户
                            </button>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-bordered am-table-compact" id="example">
                        <thead>
                        <tr>
                            <th>用户名</th>
                            <th>手机号码</th>
                            <th>金币</th>
                            <th>会员类型</th>
                            <th>会员状态</th>
                            <th>注册日期</th>
                            <th>会员等级</th>
                            <th>上次登录日期</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>用户名</th>
                            <th>手机号码</th>
                            <th>金币</th>
                            <th>会员类型</th>
                            <th>会员状态</th>
                            <th>注册日期</th>
                            <th>会员等级</th>
                            <th>上次登录日期</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @if(!empty($users))
                            @foreach($users as $u)
                                <tr>
                                    <td>
                                        @if(empty($u->name))
                                            {{$u->oauth->nickname}}
                                            @else
                                            {{$u->name}}
                                            @endif

                                    </td>
                                    <td>{{$u->phone}}</td>
                                    <td>{{$u->gold}}</td>
                                    <td>
                                        @if($u->fake ==1)
                                        @if($u->type==1)
                                            会员
                                        @elseif($u->type==2)
                                            讲师
                                        @endif
                                        @if(!empty($u->oauth))
                                            @if($u->oauth->type == 1)
                                            <span class="am-badge am-badge-danger">QQ</span>
                                                @elseif($u->oauth->type == 2)
                                                    <span class="am-badge am-badge-warning">微博</span>
                                                @endif
                                            @endif
                                            @else
                                            礼物赠送员
                                        @endif
                                    </td>
                                    <td>
                                        @if($u->status==1)
                                            正常
                                        @elseif($u->status==2)
                                            冻结
                                        @elseif($u->status==3)
                                            永久冻结
                                        @endif
                                    </td>
                                    <td>{{$u->created_at}}</td>
                                    <td>{{$u->Level}}</td>
                                    <td>{{$u->login_time}}</td>
                                    <td>
                                        <a href="{{route('admin.user_update',$u->id)}}">
                                            <button type="button"
                                                    class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                <span class="am-icon-pencil-square-o"></span>
                                                修改
                                            </button>
                                        </a>
                                        <a href="##" class="fail" rel="{{$u->id}}">
                                            <button type="button"
                                                    class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                <span class="am-icon-usd"></span>
                                                增加金币
                                            </button>
                                        </a>
                                        @if($u->status==1)
                                            <a href="{{route('admin.user_update',$u->id)}}">
                                                <button type="button"
                                                        class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                    <span class="am-icon-refresh"></span>
                                                    永久冻结
                                                </button>
                                            </a>
                                        @elseif($u->status==3)
                                            <a href="{{route('admin.user_update',$u->id)}}">
                                                <button type="button"
                                                        class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                    <span class="am-icon-refresh"></span>
                                                    恢复正常
                                                </button>
                                            </a>
                                        @endif
                                        <a href="{{route('admin.add.fake',$u->id)}}">
                                            <button type="button" class="am-btn am-btn-default am-btn-xs am-text-info am-hide-sm-only">
                                                <span class="am-icon-user"></span>
                                                添加送礼员</button>
                                        </a>

                                        <a href="{{route('admin.consumes',$u->id)}}">
                                            <button type="button" class="am-btn am-btn-default am-btn-xs am-text-info am-hide-sm-only">
                                                <span class="am-icon-yelp"></span>
                                                消费记录</button>
                                        </a>

                                        <a href="{{route('admin.user_delete',$u->id)}}">
                                            <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only">
                                                <span class="am-icon-trash-o"></span>
                                                删除</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <!-- more data -->
                        </tbody>
                    </table>
                    <hr/>
                </form>
            </div>
        </div>
        <input type="hidden" name="fail" value="">
    </div>
    <div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">增加金币</div>
            <div class="am-modal-bd">
                填写增加金币的数额
                <input type="text" class="am-modal-prompt-input">
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                <span class="am-modal-btn" data-am-modal-confirm>提交</span>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function () {
            $('#example').DataTable();
        });
        $(function () {
            $('.fail').on('click', function () {
                var url = "{{route('admin.user_add_gold')}}";
                var id = $(this).attr('rel');
                $('#my-prompt').modal({
                    relatedTarget: this,
                    onConfirm: function (e) {
                        var data = {'id': id, 'gold': e.data}
                        $.post(url, data, function (res) {
                            layer.msg(res.msg);
                            window.location.reload();
                        })
                    },
                });
            });
        });
    </script>
@stop
