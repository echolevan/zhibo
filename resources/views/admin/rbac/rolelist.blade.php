@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">角色管理</strong> /
                <small>列表</small>
            </div>
        </div>
        <hr>
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('createRole')}}">
                            <button type="button" class="am-btn am-btn-default">
                                <span class="am-icon-plus"></span> 新增角色
                            </button>
                        </a>
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
                            <th class="table-title">唯一标示</th>
                            <th class="table-type">角色名称</th>
                            <th class="table-author am-hide-sm-only">角色介绍</th>
                            <th class="table-date am-hide-sm-only">添加时间</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($roles))
                            @foreach($roles as $r)
                                <tr>
                                    <td>{{$r->id}}</td>
                                    <td>{{$r->name}}</td>
                                    <td>{{$r->display_name}}</td>
                                    <td>{{$r->description}}</td>
                                    <td class="am-hide-sm-only">{{$r->created_at}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{route('updateRole_permission',$r->id)}}">
                                                    <button type="button"
                                                            class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                        <span class="am-icon-pencil-square-o"></span> 权限编辑
                                                    </button>
                                                </a>
                                                <a href="{{route('role_info_update',$r->id)}}">
                                                    <button type="button"
                                                            class="am-btn am-btn-default am-btn-xs am-hide-sm-only">
                                                        <span class="am-icon-copy"></span> 角色编辑
                                                    </button>
                                                </a>
                                                <a href="{{route('delete_role',$r->id)}}">
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
                        共 {{$roles->count()}} 条记录
                        <div class="am-fr">
                            {!! $roles->links() !!}
                        </div>
                    </div>
                    <hr/>
                    <p>注：.....</p>
                </form>
            </div>

        </div>
    </div>
@stop
