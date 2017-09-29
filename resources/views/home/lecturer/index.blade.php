@extends('home.layout.app')

@section('content')
    <div class="container user">
        <div class="row">
            <!--左侧-->
        @include('home.lecturer.layout.left')
        <!--左侧结束-->
            <!--右侧-->
            <div class="pull-right userright">
                <h3><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>直播室信息
                    <span style="font-size: 16px;padding-left: 150pxl; float: right"> <a href="/files/构牛网OBS使用教程.doc" target="_blank" style="color: #adadad;">使用帮助</a></span>
                </h3>
                @if(empty($userinfo->lecturer->room))
                    <div class="rightcon">
                        <div class="collapse" >
                            <div class="well text-success">
                                暂未分配房间，请联系客服，请联系客服！
                            </div>
                        </div>
                    </div>
                    @else
                    @if($userinfo->lecturer->room->status == 2)
                        <div class="rightcon">
                            <div class="collapse" >
                                <div class="well text-success">
                                    你的房间已被关闭，请联系客服！
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="rightcon">
                            <ul>
                                <li>
                                    <div class="pull-left">
                                        <span class="myinfo"><img src="{{asset('homestyle/images/myinfo1.png')}}" width="36" height="36"></span>
                                        <span class="mytxt">直播室信息</span>
                                        <span class="mydetail">您可以修改直播室信息</span>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{route('lecturer_room')}}" class="rightbtn">修改</a>
                                    </div>
                                </li>

                                <li>
                                    <div class="pull-left">
                                        <span class="myinfo"><img src="{{asset('homestyle/images/mail.png')}}" width="36" height="36"></span>
                                        <span class="mytxt">推流地址</span>

                                    </div>
                                    <div class="pull-right">
                                        <a href="javascript:void (0);" class="rightbtn publishUrl">获取</a>
                                    </div>
                                </li>
                                @if($userinfo->lecturer->room->relay_room_id > 0)
                                <li>
                                    <div class="pull-left">
                                        <span class="myinfo"><img src="{{asset('homestyle/images/mail.png')}}" width="36" height="36"></span>
                                        <span class="mytxt">正在转播--{{ $userinfo->lecturer->room->relay->room_name }}</span>
                                    </div>
                                    <div class="pull-right">
                                        <a id="disconnect" data-id="{{ $userinfo->lecturer->room->id }}" href="javascript:void (0);" class="rightbtn">断开</a>
                                    </div>
                                </li>
                                @endif
                            </ul>
                            <div class="collapse" id="collapseExample" style="margin-top: 20px;display: none;">
                                <div class="well text-success">
                                    {{publishUrl($userinfo->lecturer->room->streams_name)}}
                                </div>
                            </div>
                            <div class="rightbotom"></div>
                        </div>
                    @endif
                    @endif
            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function(){
            $('.publishUrl').click(function(){
                $('#collapseExample').fadeIn(1000);
                return false;
            });
            $('#disconnect').click(function(){
                var _target = this;
                $(_target).html('断开中...');
                $.ajax({
                    type: 'post',
                    url: '{{ route("relay.cancel") }}',
                    data: { room_id: $(this).data('id'), _token: '{{ csrf_token() }}' },
                    success: function (json) {
                        $(_target).parents('li:first').remove();
                    }
                });
            });
        })
    </script>
    @stop