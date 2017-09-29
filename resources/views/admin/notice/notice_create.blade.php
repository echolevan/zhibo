@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">公告管理</strong> /
                <small>新增公告</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal">
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">公告标题/ Title(必填)</label>
                        <div class="am-u-sm-9">
                            <input type="text" value="" name="notice_title" id="notice_title">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">公告内容/Content(必填)</label>
                        <div class="am-u-sm-9">
                            <textarea id="content" name="content" style="height: 400px;"></textarea>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">公告排序/Sort</label>
                        <div class="am-u-sm-9">
                            <input type="text" name="notice_sort" value="10000" id="notice_sort">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">公告状态/Status</label>
                        <div class="am-u-sm-9" id="article_status">
                            <label class="am-radio-inline" style="line-height:8px;">
                                <input type="radio" name="notice_status" value="yes" data-am-ucheck checked>开启
                            </label>
                            <label class="am-radio-inline" style="line-height:8px;">
                                <input type="radio" name="notice_status" value="no" data-am-ucheck> 关闭
                            </label>
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
    <script type="text/javascript">
            var ue = UE.getEditor('content', {
                offsetWidth: false});
            $(function () {
                $(document).on('click', '#sub', function () {
                    var notice_status  = $('input[name="notice_status"]:checked').val();
                    if(notice_status=='yes') {
                        notice_status=1;
                    } else {
                        notice_status=0;
                    }
                    var data = {
                        title:$('#notice_title').val(),
                        sort:$('#notice_sort').val(),
                        content: UE.getEditor('content').getContent(),
                        status:notice_status,
                    };
                    var url = "{{route('addNotice')}}";
                    $.post(url,data,function (res) {
                        layer.msg(res['msg']);
                        if (res['status'] == true) {
                            setTimeout(function(){window.location.href=("{{route('noticeList')}}");}, 1000);
                        }
                    })
                });
            })
    </script>
@stop