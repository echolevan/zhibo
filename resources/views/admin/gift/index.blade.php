@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">礼物管理</strong> /
                <small>列表</small>
            </div>
        </div>
        <hr>
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">

                        <a href="{{route('gift_create')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-plus"></span>
                                新增礼物
                            </button>
                        </a>
                        <a href="{{route('gift_history')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-history"></span>
                                送礼记录
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
                            <th class="table-id">ID</th>
                            <th class="table-title">礼物名称</th>
                            <th class="table-type">价格</th>
                            <th class="table-author am-hide-sm-only">简介</th>
                            <th class="table-type">礼物图标</th>
                            <th class="table-date am-hide-sm-only">添加时间</th>
                            <th class="table-type">促销开始时间</th>
                            <th class="table-type">促销结束时间</th>
                            <th class="table-type">促销价格</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($gifts))
                            @foreach($gifts as $g)
                                <tr>
                                    <td>{{$g->id}}</td>
                                    <td><a href="#">{{$g->name}}</a></td>
                                    <td>{{$g->price}}</td>
                                    <td class="am-hide-sm-only">{{$g->description}}</td>
                                    <td>
                                        @if(!empty($g->gif))
                                            <img src="{{$g->gif}}" alt="" style="width: 50px;height: 50px;">
                                        @else
                                            没有上传礼物图标
                                        @endif
                                    </td>
                                    <td class="am-hide-sm-only">{{substr($g->create_time,0,16)}}</td>
                                    @if($g->promotion_begin_time!='0000-00-00 00:00:00')
                                        <td>{{substr($g->promotion_begin_time,0,16)}}</td>
                                        <td>{{substr($g->promotion_end_time,0,16)}}</td>
                                        <td>{{substr($g->promotion_price,0,16)}}</td>
                                    @else
                                        <td>无</td>
                                        <td>无</td>
                                        <td>无</td>
                                    @endif
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{route('gift_update',$g->id)}}">
                                                    <button type="button"
                                                            class="am-btn am-btn-default am-btn-xs am-text-secondary"><span
                                                                class="am-icon-pencil-square-o"></span> 编辑
                                                    </button>
                                                </a>
                                                {{--<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span--}}
                                                {{--class="am-icon-copy"></span> 复制--}}
                                                {{--</button>--}}
                                                <a href="{{route('gift_delete',$g->id)}}">
                                                    <button type="button"
                                                            class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only">
                                                        <span class="am-icon-trash-o"></span> 删除
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="am-u-lg-12 am-cf">
                        共 {{$gifts->count()}} 条记录
                        <div class="am-fr">
                            {!! $gifts->links() !!}
                        </div>
                    </div>
                    <hr/>
                </form>
            </div>

        </div>
    </div>
@stop
