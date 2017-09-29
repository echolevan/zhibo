@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">用户交割单列表</strong></div>
        </div>
        <hr>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">日期</th>
                            <th class="table-type">收益</th>
                            <th class="table-title">收益额</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($delivery as $d)
                            <tr>
                                <td>{{date('Y-m-d',strtotime($d->time))}}</td>
                                <td>{{$d->gain*100}}%</td>
                                <td>{{$d->earnings}}</td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a href="{{route('admin.delivery.details',[$d->user_id,$d->id])}}" target="_blank">
                                                <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                    <span class="am-icon-pencil-square-o"></span>
                                                    详情</button>
                                            </a>
                                            <a href="javascript:void (0);">
                                                <button type="button" data-id="{{$d->id}}" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only delete">
                                                    <span class="am-icon-trash-o"></span>
                                                    删除</button>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$delivery->count()}} 条记录
                        <div class="am-fr">
                            {!! $delivery->links() !!}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>

        </div>
    </div>
@stop
@section('js')
    <script>
        $(function(){
            $('.delete').click(function(){
                var id = $(this).data('id');
                var _this = $(this);
                layer.confirm('确定要删除此条交割单及交割单数据吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: 'delete',
                        url: '{{route('admin.delivery.delete')}}',
                        data:{id: id},
                        success: function(data){
                            layer.msg(data.msg);
                            _this.parent().parent().parent().parent().parent().fadeOut(600);
                            return false;
                        },error: function(){
                            layer.alert('删除失败', {icon: 5});
                        }
                    })
                });
            })
        })
    </script>
@stop