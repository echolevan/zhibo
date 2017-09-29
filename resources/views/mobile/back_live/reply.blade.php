@extends('mobile.layout.app')

@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="javascript:history.go(-1);"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;"><img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">评论回复</a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <a class="reply" href="javascript:void (0);">
                    <span style=" height:24px; display:block; float:right; margin-top:0px; margin-right:10px; color:#ff4436;">回复</span></a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div style="margin-top:60px;">
    <form class="form-group p-dynamic">
        <textarea name="liuyan" class="liuyan"  cols="" rows="10"></textarea>
    </form>
</div>
@stop
@section('js')
    <script>
        $('.reply').click(function(){
                    @if(\Auth::check())
            var id = '{{$comment_id}}';
            var contents = $('.liuyan').val();
            var back_live_id = '{{$back_live_id}}';
            if(contents == ''){
                layer.open({
                    content: '回复内容不能为空！'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                return false;
            }
            var data = {
                id: id,
                contents: contents,
                back_live_id: back_live_id
            };
            $.ajax({
                type: 'post',
                url: '{{route('reply.back_live_comment')}}',
                data: data,
                success: function(data){
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 1 //2秒后自动关闭
                    });
                    setTimeout(function () {
                        location.href = "{{route('mobile.back_live.details',$back_live_id)}}";
                    }, 1000);
                },error: function(){
                    layer.open({
                        content: '回复失败！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
            });
            @else
   layer.open({
                content: '请先登陆！'
                ,btn: ['确定']
                ,skin: 'footer'
                ,yes: function(index){
                    location.href = "{{url('mobile/login')}}";
                }
            });
            @endif
                });
    </script>
@stop