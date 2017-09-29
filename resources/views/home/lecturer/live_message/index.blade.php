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
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的直播信息</div>
                            <div class="nav nav-tabs" style="width:105px;">
                                <a href="{{route('live.message.create')}}">
                                    <img src="/homestyle/images/live_message.jpg" width="100" height="28"></a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="tab-content">
                            <div class="message-1">
                                <ul>
                                    @foreach($livemessages as $l)
                                        @if(!empty($l->user))
                                        <li>
                                            <div class="pull-left m-left">
                                                <div class="mymessage"> <img src="{{$l->thumb}}" width="60" height="60"></div>
                                                <div class="mytxt">
                                                    <div class="release-1">
                                                        <h4>{{$l->title}}</h4>
                                                        <div class="re-person">发布者：<span>
                                                                @if(empty($l->user->name))
                                                                    {{$l->user->oauth->nickname}}
                                                                    @else
                                                                {{$l->user->name}}
                                                                    @endif
                                                            </span></div>
                                                        <div class="re-txt">
                                                            <p>直播时间： {{$l->start_time}} - {{$l->end_time}}</p>
                                                            <a href="{{route('live.message.edit',$l->id)}}">查看全文></a>
                                                            <span><a data-id="{{$l->id}}" class="delete_message" style="color:red;" href="javascript:void (0);">删除</a></span>
                                                        </div>
                                                        <div class="re-txt" style="height:40px;">
                                                            <div class="pull-left"><i class="glyphicon glyphicon-time"></i> {{$l->created_time}}</div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                        @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:5px;"></div>
                <div aria-label="Page navigation">
                    {!! $livemessages->links() !!}
                </div>
            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function(){
            $('.delete_message').click(function(){
                var id = $(this).data('id');
                var _this = $(this);
                layer.confirm('确定要删除这条信息吗？', {
                    btn: ['确定','取消'],
                    title: false//按钮
                }, function(){
                    $.ajax({
                        type: 'delete',
                         url: '{{route('live.message.delete')}}',
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