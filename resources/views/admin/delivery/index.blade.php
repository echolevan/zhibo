@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">交割单列表</strong> / <small>Delivery List</small></div>
        </div>
        <hr>
        <div class="am-g">
            <form method="get">
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
                            <th class="table-type">总收益</th>
                            <th class="table-title">总收益额</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($counts as $c)
                            <tr>
                                <td><a href="{{route('admin.user_update',$c->user_id)}}" target="_blank">{{$c->username}}</a></td>
                                <td>{{$c->sum_gain*100}}%</td>
                                <td>{{$c->sum_earnings}}</td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a href="{{route('admin.delivery.list',$c->user_id)}}" target="_blank">
                                                <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                    <span class="am-icon-pencil-square-o"></span>
                                                    详情</button>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$counts->count()}} 条记录
                        <div class="am-fr">
                            {!! $counts->appends(Request::all())->links() !!}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>

        </div>
    </div>
@stop
