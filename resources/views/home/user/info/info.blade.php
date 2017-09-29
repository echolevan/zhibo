@extends('home.layout.app')

@section('content')
    <div class="container user">
        <div class="row">
            @include('home.user.menu')
            <!--右侧-->
            <div class="pull-right userright">
                <h3><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的资料
                </h3>
                <div class="rightcon">
                    <div class="person">
                        <form action="{{route('store_info')}}" method="post">
                            {{csrf_field()}}
                            <div class="personimg">
                                <a href="javascript:void(0);" class="upload">
                                    @if(empty($user->thumb))
                                        @if(!is_null($user->oauth))
                                            <img class="img-circle" src="{{$user->oauth->avatar_url}}" id="img_show"  width="96" height="96">
                                        @else
                                            <img class="img-circle" src="/homestyle/images/admin.png" id="img_show"  width="96" height="96">
                                        @endif
                                    @else
                                        <img class="img-circle" src="{{$user->thumb}}" id="img_show"  width="96" height="96">
                                    @endif
                                </a>
                            </div>
                            <input type="hidden" name="img" value="{{$user->thumb}}">
                            <input id="thumb_upload" class="am-form-group am-form-file" type="file"
                                   style="display:none;">
                            <div class="personinput">
                                <label>昵称：</label>
                                @if(empty($user->name))
                                    <input type="text" name="name" class="pertext form-control" placeholder="{{$user->oauth->nickname}}">
                                    @else
                                    <input type="text" name="name" class="pertext form-control" value="{{$user->name}}">
                                    @endif
                                <span style="font-size:14px;*color:#ff9802; margin-left:10px;">
                                    @if(session()->has('error'))
                                    <i class="glyphicon glyphicon-exclamation-sign"></i>
                                        @endif
                                </span>
                            </div>
                            <div class="clear"></div>
                            <div class="personinput">
                                <label>个人简介：</label>
                                <textarea name="sign" class="personal form-control" rows="5">{{$user->sign}}</textarea>
                            </div>
                            <div class="stepbtn1">
                                <button type="submit" class="btn steppink">保存</button>
                                <button type="button" class="btn btn-default stepwhite">返回</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
@section('js')
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script>
        //文件上传
        $('.upload').click(function(){
            $('#thumb_upload').click();
        })
        var opts = {
            url: "/user/imgs",
            type: "POST",
            success: function (result, status, xhr) {
                if (result.status == "0") {
                    layer.msg(result.msg);
                    return false;
                }
                $("input[name='img']").val(result.medium);
                $("#img_show").attr('src', result.medium);
                $(".left_thumb").attr('src', result.medium);
            },
            error: function (result, status, errorThrown) {
                layer.msg('文件上传失败', {icon: 5});
            }
        }
        $('#thumb_upload').fileUpload(opts);
    </script>
@stop