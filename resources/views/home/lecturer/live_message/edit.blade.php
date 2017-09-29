@extends('home.layout.app')
@section('css')
    <link rel="stylesheet" href="{{asset('homestyle/date/bootstrap-datetimepicker.min.css')}}"/>
@stop
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
                            <div class="recordtit"><span style="width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>编辑直播信息</div>
                        </div>
                        <div class="clear"></div>
                        <form action="{{route('live.message.update',$livemessage->id)}}" method="post">
                            {!! csrf_field()  !!}
                            {{ method_field('PUT') }}
                            <div class="tab-content">
                                <div class="message-1">
                                    <div class="viewtext">
                                        <div class="mymessage">
                                            <img class="img-circle" src="{{$userinfo->thumb}}" width="60" height="60"></div>
                                        <div class="postview">
                                            <div class="re-txt">
                                                <span class="pull-left">
                                                    <input name="title" value="{{old('title')}}{{$livemessage->title}}" type="text" class="viewtit form-control" placeholder="在此输入标题" id="viewtit" required/>
                                                </span>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="input-daterange input-group" style="margin-top: 10px;">

                                                <input name="start_time" size="16" type="text" value="{{old('start_time')}}{{$livemessage->start_time}}" placeholder="预播开始时间" readonly class="form-control start_datetime" required/>
                                                <span class="input-group-addon">至</span>
                                                <input name="end_time" size="16" type="text" value="{{old('end_time')}}{{$livemessage->end_time}}" placeholder="预播结束时间" readonly class="form-control end_datetime" required/>
                                            </div>
                                            <div class="clear"></div>
                                            <div style="height:100%;padding-top: 10px;">
                                                <button type="button" class="btn btn-success upload">
                                                    <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span>上传缩略图
                                                </button>
                                                <input type="file" id="thumb_upload" style="display:none;" />
                                                <input type="hidden" name="thumb" value="{{old('thumb')}}{{$livemessage->thumb}}" required/>
                                                <p style="margin: 5px 0 0 0;"><img id="img_show" src="{{old('thumb')}}{{$livemessage->thumb}}" /></p>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="clear"></div>
                                            <div>
                                                @if($livemessage->start_time > date('Y-m-d H:i:s'))

                                                <button type="submit" class="btn viewbtn">编辑</button>
                                                    @endif
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
    <script src="{{asset('homestyle/date/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('homestyle/date/bootstrap-datetimepicker.zh-CN.js')}}"></script>
    <script>
        $('.start_datetime').datetimepicker({
            language:  'zh-CN',
            format: 'yyyy-mm-dd hh:ii',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        }).on('changeDate', function (ev) {
            $(this).datetimepicker('hide');
        });
        $('.end_datetime').datetimepicker({
            language:  'zh-CN',
            format: 'yyyy-mm-dd hh:ii',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        }).on('changeDate', function (ev) {
            $(this).datetimepicker('hide');
        });
        $.fn.datetimepicker.dates['zh-CN'] = {
            days:       ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],
            daysShort:  ["日", "一", "二", "三", "四", "五", "六","日"],
            daysMin:    ["日", "一", "二", "三", "四", "五", "六","日"],
            months:     ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"],
            monthsShort:  ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"],
            meridiem:    ["上午", "下午"],
            //suffix:      ["st", "nd", "rd", "th"],
            today:       "今天"
        };
    </script>
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