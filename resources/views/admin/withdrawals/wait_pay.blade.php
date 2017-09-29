@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">提现管理</strong> /
                <small>等待打款列表</small>
            </div>
        </div>
        <hr>
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('examine_index')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span>
                                待审核列表
                            </button>
                        </a>
                        <a href="{{route('success_pay')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-history"></span>
                                打款成功列表
                            </button>
                        </a>
                        <a href="{{route('fail_examine')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-history"></span>
                                审核未通过列表
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
                            <th>用户类型</th>
                            <th>提现金额</th>
                            <th>实际打款金额</th>
                            <th>平台抽取金额</th>
                            <th>申请时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>申请人</th>
                            <th>用户类型</th>
                            <th>提现金额</th>
                            <th>实际打款金额</th>
                            <th>平台抽取金额</th>
                            <th>申请时间</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @if(!empty($withdrawals))
                            @foreach($withdrawals as $w)
                                <tr>
                                    <td>{{$w->user_name}}</td>
                                    <td>{{$w->user_type==1?'普通会员':'讲师'}}</td>
                                    <td>{{$w->amount}}</td>

                                    @if($w->user_type==1)
                                        <?php $proportion = config('user_withdrawals_role')['proportion'] / 100 * $w->amount;?>
                                        <td>
                                            {{$w->amount-$proportion}}
                                        </td>
                                        <td>
                                            {{$proportion}}
                                        </td>
                                        @else
                                        <?php $proportion = config('teacher_withdrawals_role')['proportion'] / 100 * $w->amount;?>
                                        <td>
                                            {{$w->amount-$proportion}}
                                        </td>
                                        <td>
                                            {{$proportion}}
                                        </td>
                                        @endif

                                        <td>{{$w->create_time}}</td>
                                        <td>
                                            <a href="{{route('edit_examine',$w->id)}}">确认已打款</a>
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
        <input type="hidden" name="fail" value="">
    </div>
    <div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">拒绝提现</div>
            <div class="am-modal-bd">
                拒绝理由(可不填写)
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
                var url = "{{route('fail_examine')}}";
                var id = $(this).attr('rel');
                $('#my-prompt').modal({
                    relatedTarget: this,
                    onConfirm: function (e) {
                        var data = {'id': id, 'fail': e.data}
                        $.post(url, data, function (res) {
                            if (res.status == false) {
                                layer.alert(res.msg)
                            }
                            window.location.reload()
                        })
                    },
                });
            });
        });
    </script>
@stop
