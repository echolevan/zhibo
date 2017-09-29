@extends('home.layout.app')
@section('css')
    <style>
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
        .masterview-left-table{display: none;}
        .active{display: block;}
        .pannel-title{border-bottom: 2px solid #f0f0f0; cursor: pointer;}
        .activeTitle, .pannel-title:hover{border-bottom: 2px solid #dd1234;}
        .masterview .masterview-right .masterview-right-hot{    padding: 0 20px; height:auto;background: #fff; overflow:hidden;}
        .masterview-hot-con .yellow-btn{ width:115px; height:42px; float:left; display:block; background:#ffb106; text-align:center; color:#fff; outline:none; border:none; margin:15px 0;border-radius:5px;}
        .masterview-hot-con .red-btn{ width:115px; height:42px; float:right; display:inline-block; background:#ff4436; text-align:center; color:#fff; outline:none; border:none;margin:15px 0; border-radius:5px;}
        .pannel-title-box{margin-top: 50px; margin-bottom: 20px; height: 50px;}
        .pannel-title{float: left; margin-right: 50px;}
    </style>
    @stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="masterview">
                <div class="masterview-ban-1"><img src="/homestyle/m_img/b2.jpg" width="1200" height="330"></div>
            </div>
            <div class="clear"></div>
            <div class="masterview">
                <div class="pull-left masterview-left-1">
                    <div class="pannel-title-box">
                        <div class="text-center pannel-title activeTitle" style="height:40px; line-height:32px;">
                            <img src="/homestyle/m_img/phb-1.png" width="36" height="34"><span style="margin-left:10px; font-size:18px; font-weight:bold;">收益榜</span>
                        </div>
                        <div class="text-center pannel-title" style="height:40px; line-height:32px;">
                        <img src="/homestyle/m_img/phb.png" width="36" height="34"><span style="margin-left:10px; font-size:18px; font-weight:bold;">总收益排行榜</span>
                        </div>
                        <div class="text-center pannel-title" style="height:40px; line-height:32px;">
                            <img src="/homestyle/m_img/nphb.png" width="36" height="34"><span style="margin-left:10px; font-size:18px; font-weight:bold;">相对日收益榜</span>
                        </div>

                    </div>
                    <!--收益排行榜-->
                    <div class="masterview-left-table active">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>名次</th>
                                <th>用户名</th>
                                <th>总收益率</th>
                                <th>已赚金额</th>
                                <th>综合评分</th>
                                <th>详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($today as $k=>$v)
                                @if(!empty($v->user))
                                    <tr>
                                        <td>
                                            @if($k+1 == 1)
                                                <img src="/homestyle/m_img/no1.png" width="28" height="24">
                                            @elseif($k+1 == 2)
                                                <img src="/homestyle/m_img/no2.png" width="28" height="24">
                                            @elseif($k+1 == 3)
                                                <img src="/homestyle/m_img/no3.png" width="28" height="24">
                                            @else
                                                {{$k+1}}
                                            @endif
                                        </td>
                                        <td class="admin-name">
                                            <a class="admin-name" href="{{route('delivery.list',$v->user_id)}}" target="_blank">{{$v->user->name}}</a></td>
                                        <td class="total-income">{{$v->gain*100}}%</td>
                                        <td>{{$v->earnings}}</td>
                                        @if(evaluate_day($v->user_id) == 0)
                                            <td>
                                                <img src="/homestyle/m_img/star.png" width="16" height="14">
                                            </td>
                                        @else
                                            <td>
                                                @for($i=0;$i<evaluate_day($v->user_id);$i++)
                                                    <img src="/homestyle/m_img/star.png" width="16" height="14">
                                                @endfor
                                            </td>
                                        @endif
                                        <td><a href="{{route('delivery.list',$v->user_id)}}" target="_blank" class="look">查看</a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--收益排行榜END-->

                    <!--总收益排行榜-->
                    <div class="masterview-left-table">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>名次</th>
                                <th>用户名</th>
                                <th>总收益率</th>
                                <th>已赚金额</th>
                                <th>综合评分</th>
                                <th>详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($counts as $k=>$v)
                                @if(!empty($v->user))
                            <tr>
                                <td>
                                    @if($k+1 == 1)
                                        <img src="/homestyle/m_img/no1.png" width="28" height="24">
                                    @elseif($k+1 == 2)
                                        <img src="/homestyle/m_img/no2.png" width="28" height="24">
                                    @elseif($k+1 == 3)
                                        <img src="/homestyle/m_img/no3.png" width="28" height="24">
                                    @else
                                        {{$k+1}}
                                    @endif
                                </td>
                                <td class="admin-name">
                                    <a class="admin-name" href="{{route('delivery.list',$v->user_id)}}" target="_blank">{{$v->user->name}}</a></td>
                                <td class="total-income">{{$v->sum_gain*100}}%</td>
                                <td>{{$v->sum_earnings}}</td>
                                @if(evaluate_count($v->user_id) == 0)
                                    <td>
                                        <img src="/homestyle/m_img/star.png" width="16" height="14">
                                    </td>
                                    @else
                                    <td>
                                        @for($i=0;$i<evaluate_count($v->user_id);$i++)
                                        <img src="/homestyle/m_img/star.png" width="16" height="14">
                                            @endfor
                                    </td>
                                    @endif
                                <td><a href="{{route('delivery.list',$v->user_id)}}" target="_blank" class="look">查看</a></td>
                            </tr>
                            @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--总收益排行榜END-->

                    <!--相对日收益排行榜-->
                    <div class="masterview-left-table">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>名次</th>
                                <th>用户名</th>
                                <th>相对日收益率</th>
                                <th>相对日赚金额</th>
                                <th>周期</th>
                                <th>综合评分</th>
                                <th>详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($today as $k=>$v)
                                @if(!empty($v->user))
                                    <tr>
                                        <td>
                                            @if($k+1 == 1)
                                                <img src="/homestyle/m_img/no1.png" width="28" height="24">
                                            @elseif($k+1 == 2)
                                                <img src="/homestyle/m_img/no2.png" width="28" height="24">
                                            @elseif($k+1 == 3)
                                                <img src="/homestyle/m_img/no3.png" width="28" height="24">
                                            @else
                                                {{$k+1}}
                                            @endif
                                        </td>
                                        <td class="admin-name">
                                            <a class="admin-name" href="{{route('delivery.list',$v->user_id)}}" target="_blank">{{$v->user->name}}</a></td>
                                        <td class="total-income">{{substr($v->gain*100/day_average($v->stock_data_id),0,5)}}%</td>

                                        <td>{{substr($v->earnings/day_average($v->stock_data_id),0,4)}}</td>
                                        <td>{{day_average($v->stock_data_id)}}天</td>
                                        @if(evaluate_day($v->user_id) == 0)
                                            <td>
                                                <img src="/homestyle/m_img/star.png" width="16" height="14">
                                            </td>
                                        @else
                                            <td>
                                                @for($i=0;$i<evaluate_day($v->user_id);$i++)
                                                    <img src="/homestyle/m_img/star.png" width="16" height="14">
                                                @endfor
                                            </td>
                                        @endif
                                        <td><a href="{{route('delivery.list',$v->user_id)}}" target="_blank" class="look">查看</a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--相对日收益排行榜END-->

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
                    <div class="masterview-right-hot" style=" margin-top:10px;">
                        <div class="masterview-hot-title"> <span><i></i>牛人观点</span> </div>
                        <div class="masterview-hot-con">
                            <ul class="masterview-right-view-p">
                                @foreach($best as $b)
                                    @if(!empty($b->user))
                                <li>
                                    <a href="{{route('details',$b->id)}}">
                                        <div class="masterview-people-img">
                                            @if(empty($b->img))
                                                <img src="{{$b->user->thumb}}" width="68" height="68">
                                                @else
                                                <img src="{{$b->img}}" width="68" height="68">
                                                @endif
                                        </div>
                                        <div class="masterview-people">
                                            <h4>{{$b->description}}</h4>
                                            <div class="re-person">发布者：
                                                @if(empty($b->user->name))
                                                    <span>{{$b->user->oauth->nickname}}</span>
                                                @else
                                                    <span>{{$b->user->name}}</span>
                                                @endif

                                            </div>
                                            <div class="re-txt">
                                                <span class="guangzhu-data" style="color:#666;">{{$b->count}}人关注</span>
                                                <span><i class="iconfont icon-xiaoxixuanzhong01"></i> ({{$b->comments->count()}})</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height:0px; overflow:hidden; *clear:both;"></div>
    @stop
@section('js')
    <script>
        $(function(){
            $('.check_auth').click(function(){
                layer.alert('请先登陆！', {icon: 6,title:false});
            })
                
            $(".pannel-title-box .pannel-title").bind("click", function(){
                var index = $(".pannel-title-box .pannel-title").index(this);
                $(".masterview .pannel-title").removeClass("activeTitle"); 
                $(".masterview .pannel-title").eq(index).addClass("activeTitle");
                
                $(".masterview .masterview-left-table").removeClass("active"); 
                $(".masterview .masterview-left-table").eq(index).addClass("active");
            });
    })
    </script>
    @stop