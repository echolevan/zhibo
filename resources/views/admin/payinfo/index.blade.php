@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">充值列表</strong> / <small>Pay List</small></div>
        </div>

        <hr>

        {{--<div class="am-g">--}}

            {{--<form method="get">--}}
                {{--<div class="am-u-sm-12 am-u-md-3">--}}
                    {{--<div class="am-input-group am-input-group-sm am-u-md-8">--}}
                        {{--<input name="name" value="{{Request::input('name')}}" type="text" class="am-form-field" placeholder="昵称" />--}}
                    {{--<span class="am-input-group-btn">--}}
                        {{--<button class="am-btn am-btn-default" type="submit">搜索</button>--}}
                    {{--</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">昵称</th>
                            <th class="table-title">充值时间</th>
                            <th class="table-type">金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pay_log as $p)
                            @if(!empty($p->user))
                                <tr>
                                    <td>
                                        @if(empty($p->user->name))
                                            {{$p->user->oauth->nickname}}
                                            @else
                                            {{$p->user->name}}
                                        @endif
                                    </td>
                                    <td>
                                        {{$p->created_time}}
                                    </td>
                                    <td>{{$p->amount}}</td>

                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$pay_log->count()}} 条记录
                        <div class="am-fr">
                            {!! $pay_log->appends(Request::all())->links() !!}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>

        </div>
    </div>
@stop