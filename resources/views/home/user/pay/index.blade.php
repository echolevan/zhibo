@extends('home.layout.app')
@section('css')
    <link rel="stylesheet" href="/jpage/css/jPages.css" >
    <link rel="stylesheet" href="/jpage/css/animate.css">
@stop
@section('css')
    <script>
        $(function () {
            var log = function(s){
                window.console && console.log(s)
            }
            $('.nav-tabs a:last').tab('show')
            $('a[data-toggle="tab"]').on('show', function (e) {
                log(e)
            })
            $('a[data-toggle="tab"]').on('shown', function (e) {
                log(e.target) // activated tab
                log(e.relatedTarget) // previous tab
            })
        })
    </script>
    @stop
@section('content')
    <div class="container user">
        <div class="row">
            @include('home.user.menu')
            <!--右侧-->
            <div class="pull-right userright">
                <h3><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>交易记录</h3>
                <div class="record">
                    <div class="money">
                        <div class="amount"><span>{{$userinfo->gold}}</span>金币</div>
                        <div class="transform"></div>
                        <div class="recharge">
                            <a href="{{route('pay.type')}}" target="_blank"> <button type="button" class="btnred">充值</button></a>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="recordimg"><img src="/homestyle/images/niu.png" width="840" height="140"></div>
                    <div class="recording">
                        <div>
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>消费明细</div>
                        </div>
                        <div class="clear"></div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home">
                                <table class="table table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>消费时间</th>
                                        <th>消费内容</th>
                                        <th>消费金额</th>
                                    </tr>
                                    </thead>
                                    <tbody id="consume">
                                    @if($consumes->isEmpty())
                                        <tr>
                                            <td colspan="4">暂无数据</td>
                                        </tr>
                                        @else
                                        @foreach($consumes as $c)
                                            <tr>
                                                <td>{{$c->created_time}}</td>
                                                <td>{{$c->type}}</td>
                                                <td>{{$c->price}}</td>
                                            </tr>
                                        @endforeach
                                        @endif

                                    </tbody>
                                </table>
                                @if($consumes->count() > 5)
                                <div aria-label="Page navigation">
                                    <div class="holder holder_consume"></div>
                                </div>
                                    @endif
                            </div>
                            <div>
                                <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>充值记录</div>
                            </div>
                            <table class="table table-bordered" >
                                <thead>
                                <tr>
                                    <th>消费时间</th>
                                    <th>订单号</th>
                                    <th>充值金额</th>
                                </tr>
                                </thead>
                                <tbody id="order_list">
                                @if($pay_log->isEmpty())
                                    <tr>
                                        <td colspan="4">暂无数据</td>
                                    </tr>
                                @else
                                    @foreach($pay_log as $p)
                                        <tr>
                                            <td>{{$p->created_time}}</td>
                                            <td>{{$p->order_id}}</td>
                                            <td>{{$p->amount}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            @if($pay_log->count() > 5)
                                <div aria-label="Page navigation">
                                    <div class="holder_order"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!--右侧结束-->
        </div>
    </div>
    @stop
@section('js')
    <script src="{{asset('/homestyle/js/bootstrap-tab.js')}}"></script>
    <script type="text/javascript" src="/jpage/js/tabifier.js"></script>
    <script src="/jpage/js/jPages.js"></script>
    <script type="text/javascript" src="/jpage/js/highlight.pack.js"></script>
    <script>
        /* when document is ready */
        $(function() {
            /* initiate plugin */
            $("div .holder_consume").jPages({
                containerID: "consume",
                previous : "上一页",
                next : "下一页",
                perPage : 5,
            });

            $("div .holder_order").jPages({
                containerID: "order_list",
                previous : "上一页",
                next : "下一页",
                perPage : 5,
            });
        });
    </script>
@stop
