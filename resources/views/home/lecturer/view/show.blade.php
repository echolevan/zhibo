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
                            <div class="recordtit"><span style="width:5px; height:35px; display:block; float:left; background:#ff4436;"></span> 我的观点</div>
                        </div>
                        <div class="clear"></div>
                        <form action="{{route('lecturer.view.update',$views->id)}}" method="post">
                            {!! csrf_field()  !!}
                            {{ method_field('PUT') }}
                            <div class="tab-content">
                                <div class="message-1">
                                    <div class="viewtext">
                                        <div class="mymessage"> <img class="img-circle" src="{{$userinfo->thumb}}" width="60" height="60"></div>
                                        <div class="postview">
                                            <div class="re-txt">
                                                {{--<span class="pull-left"><input name="title" value="{{old('title')}}{{$views->title}}" type="text" class="viewtit form-control" placeholder="在此输入标题" id="viewtit" required/></span>--}}
                                                <span class="pull-left"><input name="description" value="{{$views->description}}" type="text" class="viewtit form-control"  id="viewtit"></span>

                                                {{--<span class="pull-right"><input name="desc" value="{{old('description')}}{{$views->description}}" type="text" class="viewnum form-control" placeholder="输入股票代码" id="viewnum"></span>--}}
                                            </div>
                                            <div style="height:100%;margin-left:20px;">
                                                <button type="button" class="btn btn-success upload">
                                                    <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span>上传缩略图
                                                </button>
                                                <input type="file" id="thumb_upload" style="display:none;" />
                                                <input type="hidden" name="img" value="{{$views->img}}" />
                                                <p style="margin: 5px 0 0 0;"><img id="img_show" src="{{$views->img}}" /></p>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="viewcon">
                                                <textarea  id="content" name="contents" rows="10">{{$views->contents}}</textarea>
                                            </div>
                                            <div class="clear"></div>
                                            <div>
                                                <button type="submit" class="btn viewbtn">编辑</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
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
    <script type="text/javascript" src="/assets/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/assets/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" src="/assets/ueditor/lang/zh-cn/zh-cn.js"></script>


    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script type="text/javascript">
        var ue = UE.getEditor('content', {
            offsetWidth: false,
            maximumWords: 150,
            elementPathEnabled: false,
        });

        $('.upload').click(function(){
            $('#thumb_upload').click()
        })
        var opts = {
            url: "/lecturer/view/upload",
            type: "POST",
            success: function (result, status, xhr) {
                if (result.status == "0") {
                    layer.msg(result.msg);
                    return false;
                }
                $("input[name='img']").val(result.info);
                $("#img_show").attr('src', result.info);
            },
            error: function (result, status, errorThrown) {
                layer.msg('文件上传失败', {icon: 5});
            }
        }
        $('#thumb_upload').fileUpload(opts);
    </script>
@stop