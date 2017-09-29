@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">轮播图设置</strong> / <small>Focus</small></div>
        </div>
        <hr>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">ID</th>
                            <th class="table-title">展示讲师</th>
                            <th class="table-title">说明</th>
                            <th class="table-title">缩略图</th>
                            <th class="table-title">修改时间</th>
                            <th class="table-title">排序</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($focus as $f)
                                <tr>
                                    <td>{{$f->id}}</td>
                                    @if(empty($f->lecturer))
                                    <td>暂未选择</td>
                                    @else
                                        <td><a href="{{route('lecturer.edit',$f->lecturer_id)}}" target="_blank">{{$f->lecturer->user->name}}</a></td>
                                        @endif
                                    <td>{{$f->desc}}</td>
                                    <td>
                                        <img class="small" width="50px" height="40px" src="{{$f->small}}" />
                                        <img class="focus" width="600px" height="320px"  style="display:none;" src="{{$f->thumb}}" />
                                    </td>
                                    <td class="am-hide-sm-only">{{$f->updated_at}}</td>
                                    <td>{{$f->sort}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{route('config.edit.focus',$f->id)}}" target="_blank">
                                                    <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                        <span class="am-icon-clone"></span>
                                                        编辑</button>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>
                </form>
            </div>

        </div>
    </div>
@stop
@section('js')
    <script>
        $(function(){
            $('.small').click(function(){
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: ['600px', '320px'],
                    skin: 'layui-layer-nobg', //没有背景色
                    shadeClose: true,
                    content: $(this).next('.focus')
                });
            })
        })
    </script>
    @stop
