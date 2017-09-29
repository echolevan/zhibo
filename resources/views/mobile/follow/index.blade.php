@extends('mobile.layout.app')
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="{{route('mobile.customer')}}"><i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;">
                        <img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">关注</a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right"><a href=""><span style=" height:24px; display:block; float:right; margin-top:0px; margin-right:10px; color:#ff4436;"></span></a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div class="hot" style="margin-top:40px;">
    <div class="container">
        @if($follows->isEmpty())
            <p class="text-center" style="color:#DFDEDE;margin-top: 200px;">暂未关注主播！</p>
            @endif
        <ul class="list-group list-unstyled table-condensed attention">
            @foreach($follows as $f)
                @if(!empty($f->user) or !empty($f->user->room) or !empty($f->user->lecturer->room))
            <li>
                <div class="col-lg-5 col-md-5 col-sm-8 col-xs-8 pull-left">
                    <div class="img"><a href="{{route('mobile.live',[$f->user_id,$f->user->lecturer->room->streams_name])}}">
                            <img src="{{$f->user->thumb}}" class="img-responsive img-circle" alt="60x60"></a></div>
                    <div style="display:inline-block; margin-left:10px;">
                        <p style="font-size:1.2em; line-height:30px;">{{$f->user->name}}</p>
                        <p style="color:#999; line-height:30px;">粉丝数：{{App\Models\Follow::where('user_id',$f->user_id)->count()}}</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4  pull-right" data-toggle="modal" data-target="#exampleModal">
                    <span class="live-icon"><img src="/homestyle/m_img/live.png" class="img-responsive"></span>
                    <span data-id="{{$f->id}}" class="text-right pull-right unfollow" style="line-height:60px; color:#333333;">▪▪▪</span>
                </div>
            </li>
            <div class="clear"></div>
                @endif
                @endforeach
        </ul>
    </div>
</div>
<!--主界面内容end-->

@include('mobile.layout.footer')
@stop
@section('js')
    <script>
        $(function(){
            $('.unfollow').click(function(){
                var follow_id = $(this).data('id');
                var _this = $(this);
                layer.open({
                    content: '是否取消关注？'
                    ,btn: ['确定', '取消']
                    ,skin: 'footer'
                    ,yes: function(index){
                        $.ajax({
                            type: 'delete',
                            url: '{{route('unfollow')}}',
                            data: {follow_id: follow_id},
                            success: function(data){
                                layer.open({
                                    content: data.msg
                                    ,skin: 'msg'
                                    ,time: 2 //2秒后自动关闭
                                });
                                layer.open({content: data.msg,time: '1'})
                                setTimeout(function () {
                                    _this.parent().parent().fadeOut(1000);
                                }, 600);
                            },error: function(){
                                layer.open({
                                    content: '操作失败!'
                                    ,skin: 'msg'
                                    ,time: 2 //2秒后自动关闭
                                });
                                return false;
                            }
                        })
                    }
                });
            })
        })
    </script>
    @stop