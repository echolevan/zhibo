@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">提现管理</strong> /
                <small>审核未通过列表</small>
            </div>
        </div>
        <hr>
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('examine_index')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-history"></span>
                                待审核列表
                            </button>
                        </a>
                        <a href="{{route('wait_pay')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span>
                                待打款列表
                            </button>
                        </a>
                        <a href="{{route('success_pay')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-history"></span>
                                打款成功列表
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
                            <th>申请人</th>
                            <th>提现金额</th>
                            <th>申请时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>申请人</th>
                            <th>提现金额</th>
                            <th>申请时间</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @if(!empty($withdrawals))
                            @foreach($withdrawals as $w)
                                <tr>
                                    <td>{{$w->teacher_name}}</td>
                                    <td>{{$w->amount}}</td>
                                    <td>{{$w->create_time}}</td>
                                    <td>
                                        <a href="{{route('return_examine',$w->id)}}">回到审核列表中</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <!-- more data -->
                        </tbody>
                    </table>
                    <hr/>
                    <p>注：.....</p>
                </form>
            </div>
        </div>

    </div>

@stop
@section('js')
    <script>
        $(function () {
            $('#example').DataTable();
        });
    </script>
@stop
