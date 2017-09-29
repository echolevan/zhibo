@extends('home.layout.app')
@section('content')
    <div class="container user">
        <div class="row">
            @include('home.user.menu')
                    <!--右侧-->
            <div class="pull-right userright">
                <h3><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的关注</h3>
                <div class="attention">
                    <ul>
                        @foreach($follows as $f)
                            @if(!empty($f->user))
                        <li>
                            <a href="{{route('customer.live',$f->user_id)}}" target="_blank">
                                <div class="Anchor">
                                    <div class="attimg">
                                        <img src="{{$f->user->thumb}}" width="70" height="70">
                                        @if(!empty(liveStatus($f->user->lecturer->room->streams_name)['status']))
                                            <span class="p-txt">暂未开播</span>
                                    @elseif(getStream($f->user->lecturer->room->streams_name)['disabledTill'] == 0)
                                        <span class="p-txt" style="background:#449D44;">直播中</span>
                                @endif
                                </div>
                                    <div class="atttxt">
                                        <p><strong>{{$f->user->name}}</strong></p>
                                        <p style="font-size:13px; color:#999; margin-top:3px;"><i class="glyphicon glyphicon-user"></i> 资深专家</p>
                                    </div>
                                    <button type="button" class="cancel" data-id="{{$f->id}}">取消关注</button>

                                    </div>
                                <div class="clear"></div>
                                <div class="gohome">
                                    <span class="goline"></span>
                                    <span class="gotxt">进入他的首页</span>
                                    <span class="goline"></span>
                                </div>
                            </a>
                        </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="clear"></div>
                <div style="height:5px;"></div>
                {!! $follows->appends(Request::all())->links() !!}
            </div>

            <!--右侧结束-->
        </div>
    </div>
    <div style="height:60px;"></div>
@stop
@section('js')
    <script>
        $(function(){
           $('.cancel').click(function(){
               var follow_id = $(this).data('id');
               var _this = $(this);
               $.ajax({
                   type: 'delete',
                   url: '{{route('unfollow')}}',
                   data: {follow_id: follow_id},
                   success: function(data){
                       layer.msg(data.msg, {icon: 1});
                       setTimeout(function () {
                          _this.parent().fadeOut(1000);
                       }, 600);
                   },error: function(){
                       layer.msg('操作失败！', {icon: 5});
                       return false;
                   }
               })
           })
        })
    </script>
    @stop