@extends('admin.layouts.application')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/amazeui.datetimepicker.css')}}"/>
@stop
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">礼物</strong> /
                <small>编辑</small>
            </div>
        </div>

        <hr/>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8">
            </div>
            <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                <form class="am-form am-form-horizontal" method="post" action="{{route('gift_edit')}}">
                    <div class="am-form-group">
                        {{csrf_field()}}
                        <label for="user-name" class="am-u-sm-3 am-form-label">名称 / Name</label>
                        <div class="am-u-sm-9 am-u-md-4 am-u-end col-end">
                            <input type="text" name="name" value="{{$gift->name}}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">简介</label>
                        <div class="am-u-sm-9 am-u-md-4 am-u-end col-end">
                            <input type="text" name="description" value="{{$gift->description}}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">平常价格</label>
                        <div class="am-u-sm-9 am-u-md-4 am-u-end col-end">
                            <input type="text" name="price" value="{{$gift->price}}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">礼物图片上传(gif)</label>
                        <div class="am-u-sm-9">
                            <input id="thumb_upload1" class="am-form-group am-form-file" type="file"
                                   style="display:none;">
                            <button class="am-btn am-btn-danger am-btn-sm upload1" type="button"><i
                                        class="am-icon-cloud-upload"></i>&nbsp;&nbsp;<span
                                        class="bold">上传</span>
                            </button>
                            @if(empty($gift->gif))
                                <img src="" alt="" id="img_show_1" style="width: 50px;height: 50px;display: none">
                            @else
                                <img src="{{$gift->gif}}" alt="" id="img_show_1" >
                            @endif
                            <input id="web_log" name="gif" value="{{$gift->gif}}" type="hidden"/>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">礼物图片上传</label>
                        <div class="am-u-sm-9">
                            <input id="thumb_upload2" class="am-form-group am-form-file" type="file"
                                   style="display:none;">
                            <button class="am-btn am-btn-danger am-btn-sm upload2" type="button"><i
                                        class="am-icon-cloud-upload"></i>&nbsp;&nbsp;<span
                                        class="bold">上传</span>
                            </button>
                            @if(empty($gift->img))
                                <img src="" alt="" id="img_show_2" style="width: 50px;height: 50px;display: none">
                            @else
                                <img src="{{$gift->img}}" alt="" id="img_show_2" >
                            @endif
                            <input id="web_log" name="img" value="{{$gift->img}}" type="hidden"/>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-QQ" class="am-u-sm-3 am-form-label">促销</label>
                        <div class="am-u-sm-9">
                            <code>如礼品有促销活动，请填写以下三个选项，没有活动可不填,当前时间不在活动时间范围内，则该礼物价格为平常价格</code>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-QQ" class="am-u-sm-3 am-form-label">活动开始时间</label>
                        <div class="am-u-sm-9 am-u-md-4 am-u-end col-end">
                            <div class="am-form-group am-form-icon">
                                <i class="am-icon-calendar"></i>
                                <input size="16" type="text" readonly class="form-datetime-lang  am-form-field" name="promotion_begin_time"
                                       @if($gift->promotion_begin_time!='0000-00-00 00:00:00')
                                       value="{{$gift->promotion_begin_time}}"
                                        @endif
                                >
                            </div>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-QQ" class="am-u-sm-3 am-form-label">活动结束日期</label>
                        <div class="am-u-sm-9 am-u-md-4 am-u-end col-end">
                            <div class="am-form-group am-form-icon">
                                <i class="am-icon-calendar"></i>
                                <input size="16" type="text" readonly class="form-datetime-lang  am-form-field" name="promotion_end_time"
                                       @if($gift->promotion_begin_time!='0000-00-00 00:00:00')
                                       value="{{$gift->promotion_end_time}}"
                                        @endif
                                >

                            </div>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">活动期间价格</label>
                        <div class="am-u-sm-9 am-u-md-4 am-u-end col-end">
                            <input type="text" name="promotion_price"
                                   @if($gift->promotion_begin_time!='0000-00-00 00:00:00')
                                   value="{{$gift->price}}"
                                    @endif>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <input type="hidden" name="id" value="{{$gift->id}}">
                            <button type="submit" id="tt" class="am-btn am-btn-primary">编辑</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script src="{{asset('assets/upload/upload_gift.js')}}"></script>
    <script src="{{asset('assets/js/amazeui.datetimepicker.min.js')}}"></script>
    <script>
        (function($){
            $.fn.datetimepicker.dates['zh-CN'] = {
                days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
                daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
                daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
                months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                today: "今日",
                suffix: [],
                meridiem: ["上午", "下午"]
            };

            $('.form-datetime-lang').datetimepicker({
                language:  'zh-CN',
                format: 'yyyy-mm-dd hh:ii'
            });
        }(jQuery));
    </script>
@stop