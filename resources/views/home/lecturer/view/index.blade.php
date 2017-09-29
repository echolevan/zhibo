@extends('home.layout.app')

@section('content')
    <div class="container user">
        <div class="row">
            <!--左侧-->
            @include('home.lecturer.layout.left')
                    <!--左侧结束-->
            <!--右侧-->
            <div class="pull-right userright">
                <div class="record">
                    <div class="recording">
                        <div style=" width:100%; height:50px;border-bottom:#ddd 1px solid;">
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的观点</div>
                            <div class="nav nav-tabs" style="width:105px;">
                                <a href="{{route('lecturer.view.create')}}"><img src="/homestyle/images/view.png" width="100" height="28"></a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="tab-content">
                            <div class="message-1">
                                <ul>
                                    @foreach($view as $v)
                                    <li>
                                            <div class="pull-left">
                                                <div class="mymessage"> <img src="{{$v->img}}" width="60" height="60"></div>
                                                <div class="mytxt">
                                                    <div class="release">
                                                        <a href="{{route('lecturer.view.show',$v->id)}}"><h4>股票代码：{{$v->description}}</h4></a>
                                                        <div class="re-person">发布者：<span>{{$v->user->name}}</span></div>
                                                        <div class="re-txt">
                                                            <p>{!! subtext($v->contents,60) !!}</p>
                                                        </div>
                                                        <div class="re-txt" style="height:40px;">
                                                            <div class="pull-left"><i class="glyphicon glyphicon-time"></i> {{$v->ctime}}</div>
                                                            <div class="pull-right read">
                                                                <span data-id="{{$v->id}}" class="delete"><strong><a href="javascript:void (0);">删除</a></strong></span>
                                                                <span>阅读：<strong>{{$v->count}}人</strong></span>
                                                                <span>评论：<strong>{{$v->comments->count()}}条</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </li>
                                    <div class="clear"></div>
                                        @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:5px;"></div>
                <div aria-label="Page navigation">
                    <ul class="pagination">
                        {!! $view->links() !!}
                    </ul>
                </div>
            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function(){
            $('.delete').click(function(){
                var id = $(this).data('id');
                var _this = $(this);
                layer.confirm('确定要删除这条信息吗？', {
                    btn: ['确定','取消'],
                    title: false//按钮
                }, function(){
                    $.ajax({
                        type: 'put',
                        url: '{{route('lecturer.view.delete')}}',
                        data: {id: id},
                        success: function(data){
                            if(data.status == false){
                                layer.msg(data.msg);
                                return false;
                            }
                            layer.msg(data.msg, {icon: 1});
                            setTimeout(function () {
                                _this.parents('li').fadeOut(600);
                            }, 1000);
                        },error: function(){
                            layer.msg('操作失败！', {icon: 5});
                            return false;
                        }
                    })
                });
            })
        })
    </script>
@stop