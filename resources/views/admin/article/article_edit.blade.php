@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">文章管理</strong> /
                <small>编辑文章</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal">
                    <div data-am-widget="tabs" class="am-tabs am-tabs-default" >
                        <ul class="am-tabs-nav am-cf" style="width:40%;">
                            <li class="am-active"><a href="[data-tab-panel-0]">基本信息</a></li>
                            <li class=""><a href="[data-tab-panel-1]">其他设置</a></li>
                        </ul>
                        <div class="am-tabs-bd" style="border:1px solid #dadada;">
                            <div data-tab-panel-0 class="am-tab-panel am-active">
                                <input type="hidden" value="{{$article->id}}" id="article_id" name="article_id">
                                @if($article->type == 1)
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">股票代码(必填)</label>
                                        <div class="am-u-sm-9">
                                            <input type="text" value="{{$article->description}}" name="description" id="description">
                                        </div>
                                    </div>
                                @else
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">标题/ Title(必填)</label>
                                        <div class="am-u-sm-9">
                                            <input type="text" value="{{$article->title}}" name="article_title" id="article_title">
                                        </div>
                                    </div>
                                    @endif

                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">封面图</label>

                                    <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                                        <div class="am-form-group am-form-file new_thumb">
                                            <button type="button" class="am-btn am-btn-success am-btn-sm upload">
                                                <i class="am-icon-cloud-upload" id="loading"></i> 上传新的焦点图
                                            </button>
                                            <input type="file" id="thumb_upload">
                                            <input type="hidden" name="img" value="{{$article->img}}" />
                                        </div>

                                        <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
                                        <div>
                                            <img src="{{$article->img}}" id="img_show">
                                        </div>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">所属分类/Type(必选)</label>
                                    <div class="am-u-sm-9">
                                        <div class="am-dropdown" data-am-dropdown>
                                            <select data-am-selected id="article_type">
                                                <option value="3"
                                                        @if($article->type==3)
                                                        selected
                                                        @endif
                                                >系统文章</option>
                                                <option value="1"
                                                        @if($article->type==1)
                                                        selected
                                                        @endif
                                                >观点文章</option>
                                                <option value="2"
                                                        @if($article->type==2)
                                                        selected
                                                        @endif
                                                >我的文章</option>
                                            </select>
                                        </div>
                                </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">文章内容/Content(必填)</label>
                                    <div class="am-u-sm-9">
                                        <textarea id="content" name="contents" style="height: 400px;">{{$article->contents}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div data-tab-panel-1 class="am-tab-panel ">
                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">文章状态/Status</label>
                                    <div class="am-u-sm-9" id="article_status">
                                        <label class="am-radio-inline" style="line-height:8px;">
                                            <input type="radio" name="article_status" value="yes" data-am-ucheck
                                                   @if($article->status== 1)
                                                       checked
                                                   @endif
                                            >开启
                                        </label>
                                        <label class="am-radio-inline" style="line-height:8px;">
                                            <input type="radio" name="article_status" value="no" data-am-ucheck
                                                   @if($article->status==0)
                                                   checked
                                                    @endif
                                            > 关闭
                                        </label>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">文章标签/Label</label>
                                    <div class="am-u-sm-9">
                                            <label class="am-checkbox-inline" style="line-height:8px;">
                                                <input type="checkbox" id="article_recommend" value="" data-am-ucheck
                                                       @if($article->recommend==1)
                                                        checked
                                                        @endif> 推荐
                                            </label>
                                            <label class="am-checkbox-inline" style="line-height:8px;">
                                                <input type="checkbox" id="article_hot"  value="" data-am-ucheck
                                                       @if($article->hot==1)
                                                       checked
                                                        @endif> 热门
                                            </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="button" id="sub" class="am-btn am-btn-primary">编辑</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="/assets/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/assets/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" src="/assets/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script type="text/javascript">
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
    <script type="text/javascript">
            var ue = UE.getEditor('content', {
                offsetWidth: false,
                elementPathEnabled: false
            });
//            var ue = UE.getEditor('description',{
//                offsetWidth: false});
            $(function () {
                $(document).on('click', '#sub', function () {
                    var article_status  = $('input[name="article_status"]:checked').val();
                    if(article_status=='yes') {
                        article_status=1;
                    } else {
                        article_status=0;
                    }
                    var article_recommend=$("#article_recommend").is(':checked')
                    if(article_recommend==true)
                    {
                        article_recommend=1;
                    }else {
                        article_recommend=0;
                    }
                    var article_hot=$("#article_hot").is(':checked')
                    if(article_hot===true)
                    {
                        article_hot=
                        article_hot=0;
                    }
                    var data = {
                        id:$('#article_id').val(),
                        title:$('#article_title').val(),
                        description:$('#description').val(),
                        author:$('#article_author').val(),
                        term:$('#article_keyword').val(),
                        type:$('#article_type').val(),
                        contents: UE.getEditor('content').getContent(),
                        status:article_status,
                        hot:article_hot,
                        recommend:article_recommend,
                    };
                    var url = "{{route('updateArticle')}}";
                    $.post(url,data,function (res) {
                        console.log(res);
                        layer.msg(res['msg']);
                        if (res['status'] == true) {
                            setTimeout(function(){window.location.href=("{{route('articleList')}}");}, 1000);
                        }
                    })
                });
            })
    </script>
@stop