@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">客服管理</strong> /
                <small>编辑客服</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>

            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal">

                                <input type="hidden" value="{{$qqcs->id}}" id="qqcs_id" name="qqcs_id">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">客服名称/ Name(必填)</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" value="{{$qqcs->name}}" name="qqcs_name" id="qqcs_name">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">客服QQ/ QQ(必填)</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" value="{{$qqcs->qq}}" name="qqcs_qq" id="qqcs_qq">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">客服状态/Status</label>
                                    <div class="am-u-sm-9" id="article_status">
                                        <label class="am-radio-inline" style="line-height:8px;">
                                            <input type="radio" name="qqcs_status" value="yes" data-am-ucheck
                                                   @if($qqcs->status== 1)
                                                       checked
                                                   @endif
                                            >开启
                                        </label>
                                        <label class="am-radio-inline" style="line-height:8px;">
                                            <input type="radio" name="qqcs_status" value="no" data-am-ucheck
                                                   @if($qqcs->status==0)
                                                   checked
                                                    @endif
                                            > 关闭
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
    <script type="text/javascript">
            $(function () {
                $(document).on('click', '#sub', function () {
                    var qqcs_status  = $('input[name="qqcs_status"]:checked').val();
                    if(qqcs_status=='yes') {
                        qqcs_status=1;
                    } else {
                        qqcs_status=0;
                    }
                    var data = {
                        id:$('#qqcs_id').val(),
                        name:$('#qqcs_name').val(),
                        qq:$('#qqcs_qq').val(),
                        status:qqcs_status,
                    };
                    var url = "{{route('updateQqcs')}}";
                    $.post(url,data,function (res) {
                        console.log(res);
                        layer.msg(res['msg']);
                        if (res['status'] == true) {
                            setTimeout(function(){window.location.href=("{{route('qqcsList')}}");}, 1000);
                        }
                    })
                });
            })
    </script>
@stop