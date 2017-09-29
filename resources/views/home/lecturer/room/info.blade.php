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
                        <div style="width:100%; height:50px;border-bottom:#ddd 1px solid;">
                            <div class="recordtit"><span style="width:5px; height:35px; display:block; float:left; background:#ff4436;"></span> 开播停播</div>
                        </div>
                        <div class="clear"></div>
                        @if(empty($userinfo->lecturer->room))
                            <div class="rightcon">
                                <div class="collapse" >
                                    <div class="well text-success">
                                        暂未分配房间，请联系客服，请联系客服！
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{route('lecturer_update_room')}}" method="post">
                                {!! csrf_field() !!}
                                <div class="tab-content">
                                    <div class="message-1">
                                        <div class="viewtext">
                                            <div class="postview-1">
                                                <div class="re-txt mt20">
                                                    <label class="relable">房间ID：</label>
                                            <span class="respan">
                                                  <div class="col-xs-8">
                                                      {{$room->streams_name}}
                                                  </div>
                                            </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">转播费用：</label>
                                                    <span class="respan">
                                                    <div class="col-xs-4">
                                                        <input name="relay_amount" type="text" class="form-control" value="{{$room->relay_amount}}" required>
                                                    </div>
                                                    金币/月
                                                </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">房间标题：</label>
                                            <span class="respan">
                                                <div class="col-xs-8">

                                                    <input name="room_name" type="text" class="form-control" value="{{$room->room_name}}" required/>
                                                </div>
                                            </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">房间人数：</label>
                                            <span class="respan">
                                                <div class="col-xs-4">
                                                    <input name="number" type="text" class="form-control" value="{{$room->number}}" required/>
                                                </div>
                                                （人数限制）
                                            </span>
                                                </div>

                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">房间简介：</label>
                                            <span class="respan">
                                                <div class="col-xs-8">
                                                    <textarea type="text" class="form-control" name="desc">{{$room->desc}}</textarea>
                                                </div>
                                            </span>
                                                </div>

                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">房间公告：</label>
													<span class="respan">
														<div class="col-xs-8">
															<textarea type="text" class="form-control" name="notice">{{$room->notice}}</textarea>
														</div>
													</span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">弹幕：</label>
													<span class="respan">
															<input @if($room->barrage == 1) checked @endif type="radio" value='1' name='barrage'/>
															已开启
														   <input @if($room->barrage == 2) checked @endif type="radio" value='2' name='barrage'/>
															已关闭
													</span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">发言：</label>
													<span class="respan">
															<input @if($room->speak == 1) checked @endif type="radio" value='1' name='speak'/>
															已开启
														   <input @if($room->speak == 2) checked @endif type="radio" value='2' name='speak'/>
															已关闭
													</span>
                                                </div>
                                                <div class="clear"></div>
												
                                                <div class="re-txt mt20">
                                                    <label class="relable">vip房间：</label>
													<span class="respan">
															<input @if($room->is_vip == 1) checked @endif type="radio" value='1' name='is_vip'/>
															已关闭
														   <input @if($room->is_vip == 2) checked @endif type="radio" value='2' name='is_vip'/>
															已开启
													</span>
                                                </div>
                                                <div class="clear"></div>												
												
                                                <div class="re-txt mt20">
                                                    <label class="relable">vip房间密码：</label>
													<span class="respan">
															<input type="text" value='{{$room->vip_pass}}' name='vip_pass'/>
													</span>
                                                </div>
                                                <div class="clear"></div>												
												
                                                <div class="re-txt mt20">
                                                    <label class="relable">推流地址：</label>
                                            <span class="respan">
                                                <div class="col-xs-8">
                                                    <input type="text" id="publishurl" class="form-control" value="{{publishUrl($room->streams_name)}}" disabled />
                                                </div>
                                                 <button type="button" class="btn rebtn-border">获取</button>
                                            </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable">封面图：</label>
                                            <span class="respan">
                                                 <button type="button" class="btn btn-success upload">
                                                     <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span>上传封面图
                                                 </button>
                                                <input type="file" id="thumb_upload" style="display:none;" />
                                                <input type="hidden" name="thumb" value="{{old('thumb')}}{{$room->thumb}}" />
                                                <p style="margin: 5px 0 0 0;float:right;margin-right: 150px;"><img width="224px" height="121px" id="img_show" src="{{old('thumb')}}{{$room->thumb}}" /></p>
                                            </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable"></label>
                                                    <button type="submit" class="btn btn-orange">保存修改</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endif


                    </div>
                </div>
                <div class="clear"></div>

                <div style="height:225px;"></div>

            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
@section('js')
    <script>
        $(".rebtn-border").on('click',function(){
            var e=document.getElementById("publishurl");
            e.select();
            document.execCommand("Copy");
            layer.msg('复制成功！', {icon: 1});
        });
    </script>
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script>
        //文件上传
        $('.upload').click(function(){
            $('#thumb_upload').click()
        })
        var opts = {
            url: "/lecturer/room/upload",
            type: "POST",
            success: function (result, status, xhr) {
                if (result.status == "0") {
                    layer.msg(result.msg);
                    return false;
                }
                $("input[name='thumb']").val(result.info);
                $("#img_show").attr('src', result.info);
            },
            error: function (result, status, errorThrown) {
                layer.msg('文件上传失败', {icon: 5});
            }
        }
        $('#thumb_upload').fileUpload(opts);
    </script>
    @stop