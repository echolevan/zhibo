@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">功能管理</strong> /
                <small>列表</small>
            </div>
        </div>
        <hr>
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('createPermission')}}">
                            <button type="button" class="am-btn am-btn-default">
                                <span class="am-icon-plus"></span> 新增功能
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
                            <th class="table-type">功能名称</th>
                            <th class="table-title">功能路由</th>
                            <th class="table-date am-hide-sm-only">添加时间</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($permissions))
                            @foreach($permissions as $p)
                                <tr>
                                    <td class="parent" id="row_{{$p->id}}">{{$p->display_name}}</td>
                                    <td>{{$p->name}}</td>
                                    <td class="am-hide-sm-only">{{$p->created_at}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{route('updatePermission',$p->id)}}">
                                                    <button type="button"
                                                            class="am-btn am-btn-default am-btn-xs am-hide-sm-only">
                                                        <span class="am-icon-copy"></span> 功能编辑
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach($p->children as $c)
                                    <tr class="child_row_{{$c->pid}}">
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--{{$c->display_name}}</td>
                                        <td>{{$c->name}}</td>
                                        <td class="am-hide-sm-only">{{$c->created_at}}</td>
                                        <td>
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <a href="{{route('updatePermission',$c->id)}}">
                                                        <button type="button"
                                                                class="am-btn am-btn-default am-btn-xs am-hide-sm-only">
                                                            <span class="am-icon-copy"></span> 功能编辑
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </form>
            </div>

        </div>
    </div>
@stop
@section('js')
    <script>
        $(function() {
            //展开与折叠表格
            $('td.parent').click(function () {   // 获取所谓的父行
                $(this).parent('tr').siblings('.child_' + this.id).toggle();  // 隐藏/显示所谓的子行
            }).click();
        });
    </script>
    @stop
