@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">推广列表</strong> / <small>promotion</small></div>
        </div>
        <hr>

        <div class="am-g">
            <form method="get">
                <div class="am-u-sm-12 am-u-md-4">
                    <div class="am-input-group am-input-group-sm am-u-md-8">
                        <input name="name" value="{{Request::input('name')}}" type="text" class="am-form-field" placeholder="请输入昵称"/>
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
                    <table class="am-table  am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-type">推广人</th>
                            <th class="table-title">下级成员总计</th>
                            <th class="table-title">推广奖励总计</th>
                            <th>注册日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($promotions as $promotion)
                            @if(!$promotion->children->isEmpty())
                            <tr data-id="{{$promotion->id}}">
                                <td>
                                    <a href="{{route('admin.user_update',$promotion->id)}}" target="_blank">{{$promotion->name}}</a>
                                </td>
                                <td>
                                   {{$promotion->children->count()}}
                                </td>
                                <td>
                                    {{\App\Models\Award::where('user_id',$promotion->id)->where('type',1)->sum('price')}}金币 &nbsp;&nbsp;&nbsp;
                                    {{\App\Models\Award::where('user_id',$promotion->id)->where('type',2)->sum('price')}}元（可提现）
                                </td>
                                <td class="am-hide-sm-only">{{$promotion->created_at}}</td>
                                <td class="parent" id="row_{{$promotion->id}}">
                                    <button type="button" class="am-btn am-btn-default ">查看下级</button>
                                </td>
                            </tr>
                            @foreach($promotion->children as $p)
                                <tr data-id="{{$p->id}}" class="child_row_{{$p->pid}}">
                                    <td>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{route('admin.user_update',$p->id)}}" target="_blank">{{$p->name}}</a>
                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        {{$p->created_at}}
                                    </td>

                                </tr>
                            @endforeach
                            @endif
                        @endforeach

                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $promotions->appends(Request::all())->links() !!}
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
            //展开与折叠表格
           $('td.parent').click(function(){   // 获取所谓的父行
             $(this).parent('tr').siblings('.child_'+this.id).toggle();  // 隐藏/显示所谓的子行
             }).click();
        })
    </script>
    @stop

