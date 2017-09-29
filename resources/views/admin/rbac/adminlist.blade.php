@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员管理</strong> /
                <small>列表</small>
            </div>
        </div>
        <hr>
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">

                        <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span>
                            <a href="{{route('create_admin')}}">新增管理员</a>
                        </button>

                        {{--<button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除管理员--}}
                        {{--</button>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-id">ID</th>
                            <th class="table-title">管理员名称</th>
                            <th class="table-type">管理员账号</th>
                            <th class="table-author am-hide-sm-only">当前角色</th>
                            <th class="table-date am-hide-sm-only">添加时间</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($users))
                            @foreach($users as $u)
                                <tr>
                                    <td>{{$u->id}}</td>
                                    <td><a href="#">{{$u->name}}</a></td>
                                    <td>{{$u->email}}</td>
                                    <td class="am-hide-sm-only">
                                        @foreach($u->cachedRoles() as $v)
                                            {{$v->display_name}},
                                        @endforeach
                                    </td>
                                    <td class="am-hide-sm-only">{{$u->created_at}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{route('giverole',$u->id)}}">
                                                    <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span
                                                                class="am-icon-pencil-square-o"></span> 编辑
                                                    </button>
                                                </a>
                                                {{--<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span--}}
                                                {{--class="am-icon-copy"></span> 复制--}}
                                                {{--</button>--}}
                                                <a href="{{route('delete_admin',$u->id)}}">
                                                    <button type="button"
                                                            class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only">
                                                        <span class="am-icon-trash-o"></span> 删除
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="am-u-lg-12 am-cf">
                        共 {{$users->count()}} 条记录
                        <div class="am-fr">
                            {!! $users->links() !!}
                        </div>
                    </div>
                    <hr/>
                    <p>注：.....</p>
                </form>
            </div>

        </div>
    </div>
@stop
