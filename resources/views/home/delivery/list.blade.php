@extends('home.layout.app')
@section('css')
    <style>
        .basic-info {
            width: 100%;
            background: #fff;
            margin-top: 30px;
            padding: 15px 0;
            height: auto !important;
            overflow:hidden;
        }
        .basic-info .basic-left-1 {
            width:700px;
            float:left;
        }
        .basic-info .basic-left-img-1 {
            width: 60px;
            height: 60px;
            display: block;
            float: left;
            margin-left: 20px;
        }
        .basic-info .basic-left-txt {
            width:580px;
        }
        .basic-info .basic-left-txt .basic-left-name {
            margin-top:10px;
        }
        .basic-info .delivery-num {
            width:100%;
            padding:20px 0;
            border-bottom:#ddd 1px solid;
            overflow:hidden;
        }
        .basic-info .delivery-num .order-zsy {
            width:50%;
            float:left;
            display:block;
            color: #fe6454;
            font-size:20px;
        }
        .basic-info .delivery-num .order-fbnum {
            width:50%;
            float:right;
            display:inline-block;
            font-size:18px;
            margin-top:20px;
        }
        .basic-info .delivery-num .order-fbnum input {
            width:120px;
            padding:10px;
            border-radius:5px;
            color: #fe6454;
            text-align:center;
            font-size:18px;
        }
        .basic-left-txt .about {
            padding:10px 0;
        }
        .basic-left-txt .about #clamp-this-module {
            display:inline-block;
            margin: 0px;
            color: #666;
            display: -webkit-box;
            text-overflow: ellipsis;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .basic-left-txt .about a {
            color:#4c65e4;
            text-align:right;
        }

        .delivery-detail {
            width:100%;
            margin:auto;
            margin-top:20px;
            background:#fff;
            overflow:hidden;
            height:auto;
            border-top: 2px #ff4436 solid;
        }
        .comment-pf {
            width: 1005px;
            height: 40px;
            background: #fff;
            display: inline-block;
        }
        .table{ width:95%; margin:auto; margin-top:20px; padding:10px 0; }
        .table thead{ background:#fff1f4;}
        .table tbody tr td{vertical-align: middle;}
        .table tbody tr:hover{ background:#f5f5f5;}
        .table .admin-name{ color:#ffa829;}
        .table .total-income{ color:#ff4436;}
        .table .look{color:#ff4436;}
        .table img{ text-align:center;}
        .table tr{ height:45px; line-height:45px;}
        .table tr th{ padding:0px; line-height:45px; text-align:center;     vertical-align: middle;}
        .table tr td{ padding:0px; line-height:45px; text-align:center;     vertical-align: middle;}
        .table > thead > tr > th {
            vertical-align: middle !important;
            border-bottom: 1px solid #ddd;
        }
        .masterview-left-table{padding-bottom:20px;background: #fff;}
        .masterview-left-table h3{ width:95%; margin:auto; color:#646464; padding:10px 0px; padding-top:20px;font-size:23px; font-weight:bold;}
        .masterview-left-table h3 i{ width:24px; height:25px; float:left; margin-right:10px; display:block; background:url(/homestyle/images/dede.png) center no-repeat;}
        .masterview-left-table .table-time{width:95%; margin:auto; padding:30px 0px; border-bottom:#ddd 1px solid;}
        .masterview-left-table .table-time label{font-weight:400;}
        .masterview-left-table .table-time input{ width:115px; margin-left:20px; padding:4px 3px; border:#ccc 1px solid;}
        .masterview-left-table .table-time .re-time{ display:inline; margin-left:10px;}
        .masterview-left-table .table-time .re-time a{ padding:2px 10px; color:#666;}
        .masterview-left-table .table-time .re-time a:hover{ background:#999999; border-radius:5px; color:#fff;}
        .masterview-left-table .table-time .re-time a.on{background:#999999; border-radius:5px; color:#fff;}
        .masterview .masterview-right .masterview-right-hot{    padding: 0 20px; height:auto;background: #fff; overflow:hidden;}
        .masterview-hot-con .yellow-btn{ width:115px; height:42px; float:left; display:block; background:#ffb106; text-align:center; color:#fff; outline:none; border:none; margin:15px 0;border-radius:5px;}
        .masterview-hot-con .red-btn{ width:115px; height:42px; float:right; display:inline-block; background:#ff4436; text-align:center; color:#fff; outline:none; border:none;margin:15px 0; border-radius:5px;}
    </style>
    <link href="/homestyle/css/second.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('homestyle/date/bootstrap-datetimepicker.min.css')}}"/>
    @stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="basic-info">
                <div class="basic-left-1">
                    <div class="basic-left-img-1"> <img src="{{$check_user->thumb}}" width="60" height="60" class="img-circle"> </div>
                    <div class="basic-left-txt">
                        <div class="basic-left-name">{{$check_user->name}}</div>
                        <div class="delivery-num">
                            <div class="order-zsy">
                                <p><span style="font-size:48px;">{{$sum*100}}</span> <span style="position:relative; top:10px;">%</span></p>
                                <p style="color:#666; font-size:16px; margin-left:25px;">总收益率</p>
                            </div>
                            <div class=" order-fbnum"> <span>共发布交割单</span>
                                <input type="text" value="{{$delivery->count()}}">
                                <span>个</span> </div>
                        </div>
                        <div class="about">
                            <p><span style="float:left;">个人简介：</span><span id="clamp-this-module">{{$check_user->sign}}</span>
                            <p>
                            <p style="text-align:right;"><a href="{{route('customer.live',$check_user->id)}}" target="_blank">更多信息 >></a></p>
                        </div>
                    </div>
                </div>
                <div class=" pull-right" style="margin-right:10px;"> <img src="/homestyle/images/b3.jpg" width="460" height="258"></div>
            </div>
            <div class="clear"></div>
            <div class="masterview">
                <div class="pull-left masterview-left-1">

                    <!--总收益排行榜-->
                    <div class="masterview-left-table">
                        <h3><i></i> 我的交割单</h3>
                        <div class="table-time">
                            <form method="get">
                                <label>时间：</label>
                                <input style="width:200px;" name="start_time" size="16" type="text" value="{{Request::input('start_time')}}" placeholder="开始时间"  class="start_datetime" /> &nbsp;&nbsp;<span>至</span>
                                <input style="width:200px;" name="end_time" size="16" type="text" value="{{Request::input('end_time')}}" placeholder="结束时间"  class="end_datetime" required/>
                                <button type="submit" class="btn btn-info">查找</button>
                            </form>
                        </div>
                        <table class="table ">
                            <caption class="text-center" style="height:50px; margin-bottom:20px;line-height:32px;">
             <span style="margin-left:20px; font-size:18px; font-weight:bold;">
                总收益：<b style="color:#ff4536;">{{$sum*100}}%</b>
             </span>
                            </caption>
                            <thead>
                            <tr>
                                <th>时间</th>
                                <th>收益率</th>
                                <th>已赚金额</th>
                                <th>综合评分</th>
                                <th>详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($delivery as $d)
                                @if(!empty($d->user))
                            <tr>
                                <td>{{date('Y-m-d',strtotime($d->time))}}</td>
                                <td class="total-income">{{$d->gain*100}}%</td>
                                <td>{{$d->earnings}}</td>
                                @if($d->comments->sum('evaluate') == 0)
                                    <td>
                                        <img src="/homestyle/images/star.png" width="16" height="14">
                                        <img src="/homestyle/images/star01.jpg" width="16" height="14">
                                        <img src="/homestyle/images/star01.jpg" width="16" height="14">
                                        <img src="/homestyle/images/star01.jpg" width="16" height="14">
                                        <img src="/homestyle/images/star01.jpg" width="16" height="14">
                                    </td>
                                    @else
                                    <td>
                                        <img @if(round($d->comments->sum('evaluate'))/($d->comments->count()) >= 0) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                        <img @if(round($d->comments->sum('evaluate'))/($d->comments->count()) >= 2) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                        <img @if(round($d->comments->sum('evaluate'))/($d->comments->count()) >= 3) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                        <img @if(round($d->comments->sum('evaluate'))/($d->comments->count()) >= 4) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                        <img @if(round($d->comments->sum('evaluate'))/($d->comments->count()) >= 5) src="/homestyle/images/star.png" @else src="/homestyle/images/star01.jpg" @endif width="16" height="14">
                                    </td>
                                    @endif

                                <td><a target="_blank" href="{{route('delivery.details',[$d->user_id,$d->id])}}" class="look">查看</a></td>
                            </tr>
                            @endif
                                @endforeach
                            </tbody>
                        </table>
                        {!! $delivery->appends(Request::all())->links() !!}
                    </div>
                    <!--总收益排行榜END-->
                </div>
                <div class="pull-right masterview-right">
                    <div class="masterview-right-hot">
                        <div class="masterview-hot-title"> <span><i></i> 上传交割单</span> </div>
                        <div class="masterview-hot-con">
                            <div style=" width:206px;margin-top:10px; margin:auto;"><img src="/homestyle/images/jgd.png" width="206" height="118"></div>
                            <div style="width:240px;margin-top:10px; margin:auto;">
                                <a href="/consult.xlsx"><span><button type="button" class="yellow-btn">下载参考表格</button></span></a>
                                @if (Auth::guest())
                                    <button type="button" class="red-btn check_auth">立即上传</button></span>
                                @else
                                    <a target="_blank" href="{{route('add.stock')}}"><span><button type="button" class="red-btn">立即上传</button></span></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="masterview-right-img" style=" margin-top:10px;">
                        <img src="/homestyle/images/jpzb.png" width="280" height="330">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stop
@section('js')
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
        //点击关闭按钮
        $("closealert").click(function(){
            $("#login-modal").hide();
        })
        $(function () {
            $('.check_auth').click(function(){
                layer.alert('请先登陆！', {icon: 6,title:false});
            })

            $('#myTab a:last').tab('show');
        })
    </script>
    <script src="/homestyle/js/bootstrap-tab.js"></script
    >
    @stop