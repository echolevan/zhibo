@extends('home.layout.app')
@section('content')
    <div class="container user">
        <div class="row">
            @include('home.lecturer.layout.left')
                    <!--右侧-->
            <div class="pull-right userright" style="background:#f2f2f5; border:#ddd 1px solid; padding:0px;">
                <div class="official">
                    <div class="off-tit">
                        <span class="pull-left"><a href="{{route('lecturer.message')}}" class="back"><img src="/homestyle/images/back.png" width="16" height="16"></a></span>
                        <div class="offname">来自
                            @if(empty($message->user->name))
                                <strong>{{$message->user->oauth->nickname}}的提问</strong>
                                @else
                                <strong>{{$message->user->name}}的提问</strong>
                                @endif

                        </div>
                    </div>
                    <div class="talk_recordbox" data-id="{{$message->id}}">
                        <div class="user">
                            @if(empty($message->user->thumb))
                                <img src="{{$message->user->oauth->avatar_url}}" class="img-circle" width="50" height="50">
                            @else
                                <img src="{{$message->user->thumb}}" class="img-circle" width="50" height="50">
                            @endif
                        </div>
                        <div class="talk_recordtextbg"> &nbsp;</div>
                            <div class="talk_recordtext">{{$message->title}}</div>
                    </div>
                        <div class="Sendtime">
                            <span>{{$message->created_time}}</span>
                        </div>

                        <div class="talk_recordboxme">
                            @if(!empty($message->reply))
                            <div class="user">
                                <img width="50" height="50" src="{{$message->user->thumb}}" class="img-circle">
                                </div>
                            <div class="talk_recordtextbg"> &nbsp;</div>
                            <div class="talk_recordtext" id="question">{{$message->reply}}</div>
                            @endif
                        </div>
                    @if(!empty($message->reply))
                    <div class="Sendtime">
                        <span>以上为历史记录</span>
                    </div>
                    @endif
                    @if(empty($message->reply))
                    <div class="send">
                        <form>
                            <div>
                                <input name="reply" type="text" class="sendtext" placeholder="输入您的回答！">
                                <button type="button" class="sendbtn">发送</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <!--右侧结束-->
        </div>
    </div>
    <div style="height:60px;"></div>
@stop
@section('js')
    <script>
        $(function(){
            $('.sendbtn').click(function(){
                var reply = $('input[name=reply]').val();
                var message_id = $('.talk_recordbox').data('id');
                if (reply == '') {
                    layer.msg('回复内容不能为空！');
                    return false;
                }
                var ttt = $.ajax({
                    type: 'post',
                    url: '{{route('lecturer.reply.question')}}',
                    data: {reply: reply,message_id:message_id},
                    success: function(data){
                        if(data.status == false){
                            layer.msg(data.msg);
                            return false;
                        }
                        setTimeout(function () {
                            layer.msg('回复成功！', {icon: 1});
                        }, 500);
                        var message = '<div class="user">' +
                                '<img width="50" height="50" src="'+ data.info.thumb +'" class="img-circle">' +
                                '</div>'+
                                '<div class="talk_recordtextbg"> &nbsp;</div>'+
                                '<div class="talk_recordtext" id="question">'+ data.info.msg +'</div>';
                        $(message).appendTo('.talk_recordboxme');
                        setTimeout(function () {
                            layer.tips('5分钟内可点击取消回复！', '#question', {
                                tips: [4, '#E4B458']
                            });
                            window.location.reload()
                        }, 2000);
                        return false;

                    },error: function(){
                        layer.msg('回复失败！', {icon: 5});
                        return false;
                    }
                })
                console.log(ttt);

            });

            @if($time < 5)
            $('#question').mouseover(function(){
                layer.tips('5分钟内可点击取消回复！', '#question', {
                    tips: [4, '#E4B458']
                });
            })
            $('#question').click(function(){
                var message_id = $('.talk_recordbox').data('id');
                layer.msg('你确定要撤销回复吗？', {
                    time: 0 //不自动关闭
                    ,btn: ['确定', '取消']
                    ,yes: function(index){
                        layer.close(index);
                        $.ajax({
                            type: 'put',
                            url: '{{route('lecturer.remove.reply')}}',
                            data: {message_id: message_id},
                            success: function(data){
                                if(data.status == false){
                                    layer.msg(data.msg);
                                    return false;
                                }
                                layer.msg(data.msg, {icon: 1});
                                setTimeout(function () {
                                    window.location.reload()
                                }, 1000);
                                return false;
                            },error: function(){
                                layer.msg('撤回失败！', {icon: 5});
                                return false;
                            }
                        })
                    }
                });
            })
            @endif
        })
    </script>
    @stop