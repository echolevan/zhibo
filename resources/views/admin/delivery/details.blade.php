@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">用户交割单详情</strong></div>
        </div>
        <hr>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">日期</th>
                            <th class="table-type">操作</th>
                            <th class="table-title">证券代码</th>
                            <th class="table-set">证券名称</th>
                            <th class="table-title">成交数量</th>
                            <th class="table-title">成交均格</th>
                            <th class="table-title">发生金额</th>
                            <th class="table-title">后资金额</th>
                            <th class="table-title">交易市场</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($details as $d)
                            <tr>
                                <td>{{date('Y-m-d',strtotime($d->time))}}</td>
                                <td>{{$d->operate}}</td>
                                <td>{{$d->code}}</td>
                                <td>{{$d->name}}</td>
                                <td>{{$d->number}}</td>
                                <td>{{$d->t_price}}</td>
                                <td>{{$d->h_price}}</td>
                                <td>{{$d->price}}</td>
                                <td>{{$d->market}}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$details->count()}} 条记录
                        <div class="am-fr">
                            {!! $details->links() !!}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>

        </div>
    </div>
@stop
