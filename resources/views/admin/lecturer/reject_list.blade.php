@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">讲师申请驳回列表</strong> / <small>Lecturer Reject</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">昵称</th>
                            <th class="table-date am-hide-sm-only">申请日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lecturer as $l)
                            @if(!empty($l->user))
                                <tr>
                                    <td><a href="#">{{$l->user->name}}</a></td>
                                    <td class="am-hide-sm-only">{{$l->created_time}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{route('lecturer.check.info',$l->id)}}" target="_blank">
                                                    <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 详情</button>
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
                        共 {{$lecturer->count()}} 条记录
                        <div class="am-fr">
                            {!! $lecturer->links() !!}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>

        </div>
    </div>
@stop