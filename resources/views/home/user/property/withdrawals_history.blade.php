@extends('home.layout.app')
@section('css')
    <link rel="stylesheet" href="/jpage/css/jPages.css" >
    <link rel="stylesheet" href="/jpage/css/animate.css">
@stop
@section('content')
    <div class="container user">
        <div class="row">
            @include('home.user.menu')
        <!--右侧-->
            <div class="pull-right userright" style="height:auto;">
                <h3><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>资产管理
                </h3>
                <div class="record">
                    <div class="money">
                        <div class="amount">可提现金额：<span>{{$userinfo->award/10}}</span>元</div>
                        <div class="transform">金币：{{$userinfo->gold}}</div>
                        <div class="recharge">
                            <a href="{{route('withdrawals')}}">
                                <button type="button" class="btnred">提现</button>
                            </a>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="recording">
                        <div class="recordtit"><span
                                    style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>提现记录
                        </div>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>提现时间</th>
                                <th>扣除金额</th>
                                <th>收款账号</th>
                                <th>结算状态</th>
                            </tr>
                            </thead>
                            <tbody id="ws">
                            @if(!empty($ws))
                                @foreach($ws as $w)
                                    <tr>
                                        <td>{{$w->create_time}}</td>
                                        <td><strong>-{{$w->amount}}</strong>元</td>
                                        <td><span>{{$w->account}}</span></td>
                                        @if($w->status==1)
                                            <td class="paidmoney">审核中</td>
                                        @elseif($w->status==2)
                                            <td class="paidmoney">审核通过</td>
                                        @elseif($w->status==3)
                                            <td class="paid">已打款</td>
                                        @elseif($w->status==10)
                                            <td>申请失败</td>
                                        @elseif($w->status==20)
                                            <td>未通过审核</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        @if($ws->count() > 5)
                            <div class="holder holder_ws"></div>
                        @endif
                    </div>
                    @if($userinfo->type == 2)
                    <div class="clear"></div>
                    <div class="recording">
                        <div>
                            <div class="recordtit"><span
                                        style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>收礼记录
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>赠送者</th>
                                        <th>礼物名称</th>
                                        <th>总价值</th>
                                        <th>送礼时间</th>
                                    </tr>
                                    </thead>
                                    <tbody id="gif">
                                    @if(!empty($gifts))
                                        @foreach($gifts as $g)
                                            <tr>
                                                <td><strong>{{$g->send_name}}</strong></td>
                                                <td>{{$g->gift_name}}*{{$g->num}}</td>
                                                <td><strong>{{$g->all_price}}</strong> 金币</td>
                                                <td>{{$g->create_time}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                @if($gifts->count() > 5)
                                    <div class="holder holder_gif"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="clear"></div>
                    <div class="recording">
                        <div class="recordtit"> <span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的推广 </div>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>时间</th>
                                <th>来源者</th>
                                <th>类型</th>
                                <th>我的奖励</th>
                            </tr>
                            </thead>
                            <tbody id="itemContainer">
                            @foreach($awards as $a)
                                <tr>
                                    <td>{{$a->created_time}}</td>
                                    <td><strong>
                                            {{$a->user->name}}
                                        </strong></td>
                                    <td class="paid">
                                        @if($a->type == 1)
                                            注册成功
                                        @else
                                            消费
                                        @endif
                                    </td>
                                    @if($a->type == 2)
                                        <td class="paidmoney">+{{$a->price}}元
                                            <small class="paid">(可提现)</small>
                                        </td>
                                    @else
                                        <td class="paidmoney">+{{$a->price}}金币
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($awards->count() > 5)
                            <div class="holder"></div>
                        @endif
                    </div>
                </div>
            </div>

            <!--右侧结束-->
        </div>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="/jpage/js/tabifier.js"></script>
    <script src="/jpage/js/jPages.js"></script>
    <script type="text/javascript" src="/jpage/js/highlight.pack.js"></script>
    <script>
        $(function() {
            /* initiate plugin */
            $("div .holder").jPages({
                containerID: "itemContainer",
                previous : "上一页",
                next : "下一页",
                perPage : 5,
            });

            $("div .holder_gif").jPages({
                containerID: "gif",
                previous : "上一页",
                next : "下一页",
                perPage : 5,
            });

            $("div .holder_ws").jPages({
                containerID: "ws",
                previous : "上一页",
                next : "下一页",
                perPage : 5,
            });
        });
        </script>
    @stop
