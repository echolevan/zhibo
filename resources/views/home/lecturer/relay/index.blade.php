@extends('home.layout.app')

@section('content')
    <div class="container user">
        <div class="row">
            <!--左侧-->
        @include('home.lecturer.layout.left')
        <!--左侧结束-->
            <!--右侧-->
            <div class="pull-right userright">
                <h3>
                    <span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>转播地址
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
                            <div class="relay-content">
                                <div class="relay-image">
                                    @if(empty($userinfo->thumb))
                                        @if(!is_null($userinfo->oauth))
                                            <img class="img-circle" src="{{$userinfo->oauth->avatar_url}}" id="img_show"  width="60" height="60">
                                        @else
                                            <img class="img-circle" src="/homestyle/images/admin.png" id="img_show"  width="60" height="60">
                                        @endif
                                    @else
                                        <img class="img-circle" src="{{$userinfo->thumb}}" id="img_show"  width="60" height="60">
                                    @endif
                                </div>
                                <div class="relay-media">
                                    <form method="post">
                                        <div class="relay-message">
                                            <textarea title="relay" class="relay-textarea" name="room-url" placeholder="请输入转播地址："></textarea>
                                            <span class="relay-sp" style="display: none">20000金币/月</span>
                                        </div>
                                        <button class="relay-btn" type="submit" disabled>一键转播</button>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    </form>
                                </div>
                            </div>
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
        $('.relay-textarea').change(function(){
            var _target = $(this);
            $.ajax({
                url: '{{ route("relay.amount") }}',
                type: 'POST',
                dataType: 'json',
                data: {roomUrl: _target.val()},
                success: function (json) {
                    if(json.code == 0){
                        $('.relay-sp').text(json.amount + '金币/月').show();
                        $('.relay-btn').removeAttr('disabled');
                    }else {
                        $('.relay-sp').text(json.error).show();
                        $('.relay-btn').attr('disabled', 'disabled');
                    }
                },
                error: function (xhr, text) {
                    if(xhr.status == 422){
                        var json = JSON.parse(xhr.responseText);
                        $('.relay-sp').text(json.roomUrl.join(',')).show();
                        $('.relay-btn').attr('disabled', 'disabled');
                    }else{
                        $('.relay-sp').text(text).show();
                        $('.relay-btn').attr('disabled', 'disabled');
                    }
                }
            });
        })
    })
</script>
@stop