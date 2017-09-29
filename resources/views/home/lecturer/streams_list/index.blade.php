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
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的直播历史</div>
                        </div>
                        <div class="clear"></div>
                        <div class="tab-content">
                            <div class="message-1">
                                <ul>
                                    @foreach($history as $h)
                                        <li>
                                            <a href="{{route('back.live.details',$h->id)}}">
                                                <div class="pull-left m-left">
                                                    <div class="mytxt">
                                                        <div class="release-1">
                                                            <h4>{{$h->title}}</h4>
                                                            <div class="re-person">发布者：<span>{{$h->user->name}}</span></div>
                                                            <div class="re-txt" style="height:40px;">
                                                                <div class="pull-left"><i class="glyphicon glyphicon-time"></i> {{$h->created_time}}</div>
                                                                <div class="pull-right read">
                                                                    <span>观看：<strong>{{$h->count}}人</strong></span>
                                                                    <span>评论：<strong>11条</strong></span>
                                                                </div>
                                                            </div>
                                                            <a data-id="{{$h->id}}" href="javascript:void (0);" class="live_delete"><p style="color:red;font-size: 12px;">删除</p></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pull-right m-right">
                                                    <img src="http://{{$h->thumb}}" width="152" height="102">
                                                </div>
                                            </a>
                                        </li>
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
                        {!! $history->links() !!}
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
            $('.live_delete').click(function(){
                var id = $(this).data('id');
                var _this = $(this);
                layer.confirm('确定要删除这条直播记录吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.ajax({
                        type: 'put',
                        url: '{{route('history.live.delete')}}',
                        data: {id: id},
                        success: function(data){
                            if(data.status == false){
                                layer.msg(data.msg);
                                return false;
                            }
                            layer.msg(data.msg);
                            _this.parent().parent().parent().parent().fadeOut(600);
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