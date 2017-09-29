@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">客服管理</strong> / <small>客服列表</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('createQqcs')}}">
                            <button type="button" class="am-btn am-btn-success"><span class="am-icon-plus"></span>添加客服</button>
                        </a>

                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm">
                    <input type="qqcs_key" value="" id="qqcs_key" class="am-form-field">
                    <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" id="btn_search" type="button">搜索</button>
          </span>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover">
                        <thead>
                        <tr>
                            <th class="table-id">ID</th>
                            <th class="table-title">客服名称</th>
                            <th class="table-title">QQ</th>
                            <th class="table-type">客服状态</th>
                            <th class="table-date am-hide-sm-only">末次修改日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($qqcss))
                            @foreach($qqcss as $key=>$value)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->qq}}</td>
                                @if($value->status==1)
                                <td class="am-hide-sm-only">开启</td>
                                @else <td class="am-hide-sm-only">关闭</td>
                                @endif

                            <td class="am-hide-sm-only">{{date('Y-m-d H:i:s',$value->ctime)}}</td>
                            <td class="am-hide-sm-only">{{date('Y-m-d H:i:s',$value->etime)}}</td>
                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a href="{{route('editQqcs',$value->id)}}" style="border: none"><button type="button" class="am-btn am-btn-success am-radius am-btn-xs"><span class="am-icon-pencil-square-o"></span> 编辑</button></a>
                                        <a><button type="button" class="am-btn am-btn-danger am-radius am-btn-xs" data-id="{{$value->id}}" id="btn_del"><span class="am-icon-trash-o"></span> 删除</button></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$qqcss->count()}} 条记录
                        <div class="am-fr">
                            {!! $qqcss->links() !!}
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
        $(function () {
            $(document).on('click', '#btn_del', function () {
                var qqcsid = $(this).data('id');
                var data = {
                    id:qqcsid,
                };
                var url = "{{route('delQqcs')}}";
                $.get(url,data,function (res) {
                    layer.msg(res['msg']);
                    if (res['status'] == true) {
                        setTimeout(function(){window.location.href=("{{route('qqcsList')}}");}, 500);
                    }
                })
            });
        })
        $(function () {
            $(document).on('click', '#btn_search', function () {
                var qqcs_key= $('#qqcs_key').val();
                var url = "{{route('searchQqcs')}}"+'/?keyword='+qqcs_key;
                window.location.href=(url);
            })
        })
    </script>
@stop