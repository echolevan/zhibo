@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新建房间</strong> / <small>Create Room</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <div class="am-u-sm-12 am-u-sm-centered">
                    <p>房间信息由讲师自己填充，点击创建，即可生成新的直播间。</p>
                 <hr>
                </div>
                <form  class="am-form am-form-horizontal">
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            房间名称
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="room_name" type="text"  placeholder="不可重复" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            房间分配
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">

                                <select data-am-selected="{searchBox: 1}" class="lecturer">
                                    <option value="-1">选择要分配的讲师</option>
                                    @foreach($lecturer as $l)
                                        @if(empty($l->room))
                                            @if(!empty($l->user))
                                        <option value="{{$l->id}}">{{$l->user->name}}</option>
                                                @endif
                                        @endif
                                    @endforeach
                                </select>

                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            房间人数限制
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="number" type="number"  placeholder=">0" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            简介
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <textarea class="desc" type="text"></textarea>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            公告
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <textarea class="notice" type="text"></textarea>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            弹幕开关
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <label class="am-checkbox am-success">
                                <input name="barrage" type="checkbox" checked="checked" value="1" data-am-ucheck="" class="am-ucheck-checkbox">
                                <span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i class="am-icon-checked"></i></span>
                            </label>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            发言开关
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <label class="am-checkbox am-success">
                                <input name="speak" type="checkbox" checked="checked" value="1" data-am-ucheck="" class="am-ucheck-checkbox">
                                <span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i class="am-icon-checked"></i></span>
                            </label>
                        </div>
                    </div>

                    {{--<div class="am-g am-margin-top">--}}
                        {{--<div class="am-u-sm-4 am-u-md-2 am-text-right">--}}
                            {{--抽奖开关--}}
                        {{--</div>--}}
                        {{--<div class="am-u-sm-8 am-u-md-4 am-u-end col-end">--}}
                            {{--<label class="am-checkbox am-success">--}}
                                {{--<input name="luck" type="checkbox" value="1" data-am-ucheck="" class="am-ucheck-checkbox">--}}
                                {{--<span class="am-ucheck-icons"><i class="am-icon-unchecked"></i><i class="am-icon-checked"></i></span>--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <hr data-am-widget="divider" style="" class="am-divider am-divider-dotted" />

                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label"></label>
                        <button class="am-btn am-btn-secondary make_room" type="button">创建</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop

@section('js')
    <script>
        $(function(){
            $(".am-gallery-item").hover(function () {
                $('.file-panel').fadeIn(300);
            }, function () {
                $('.file-panel').fadeOut(300);
            });

            $('.make_room').click(function(){
                var room_name = $('input[name=room_name]').val();
                var lecturer_id = $(".lecturer option:selected").val()
                var desc = $('.desc').val();
                var notice = $('.notice').val();
                var thumb = $('input[name=thumb]').val();
                var number = $('input[name=number]').val();
                //var luck =  $('input[name=luck]').is(':checked');
                var barrage =  $('input[name=barrage]').is(':checked');
                var speak =  $('input[name=speak]').is(':checked');
//                if(luck == true){
//                    luck = 1;
//                }else{
//                    luck = 2;
//                }
                if(barrage == true){
                    barrage = 1;
                }else{
                    barrage = 2;
                }
                if(speak == true){
                    speak = 1;
                }else{
                    speak = 2;
                }
                if(lecturer_id == -1){
                    lecturer_id = '';
                }
                var data = {
                    room_name: room_name,
                    desc: desc,
                    notice: notice,
                    thumb: thumb,
                    number: number,
                  //  luck: luck,
                    barrage: barrage,
                    speak: speak,
                    lecturer_id: lecturer_id
                };
                $.ajax({
                    type: 'post',
                    url: '{{route('room.store')}}',
                    data: data,
                    success: function(data){
                        if(data.status == false){
                            layer.msg(data.msg);
                            return false;
                        }
                        layer.msg(data.msg, {icon: 6});
                        setTimeout(function () {
                            location.href = "{{route('room')}}";
                        }, 2000);
                        return false;
                    },error: function(){
                        layer.msg('添加失败！');
                        return false;
                    }
                })
            })
        })
    </script>

    @stop