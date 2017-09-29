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

            <div class="pull-right userright" style="height:1000px;">
                <h3><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>资产管理</h3>
                <div class="record">
                    <div class="recordimg"><img src="/homestyle/images/3.png" width="840" height="218"></div>
                    <div class="clear"></div>
                    <div class="links">
                        <form>
                            <label>专属邀请推广链接：</label>
                            <input id="linkinput" type="text" onClick="copyUrl()" class="linkinput form-control" value="http://{{$_SERVER['SERVER_NAME']}}/?forumid={{$userinfo->id}}&user_id={{rand(1000000, 9999999)}}&token={{md5(env('APP_KEY').$userinfo->id)}}" id="www">
                            <button type="button" class="linkbtn">复制链接</button>
                        </form>
                    </div>
					
					
                    <div style="margin:20px 0">
						<p style="text-aligncenter;height:35px;line-height:35px;font-size:14px;font-weight: 400">填写直播间地址点击生成推广链接：</p>

						<input style="background:#f5f5f5;width:425px;height:35px;padding:3px;display:inline;" id="roomLinks" type="text" value=""/>
						<button type="button" style="width: 130px;height: 35px;display: inline-block;border: #ff4436 1px solid;color: #ff4436;text-align: center;margin-left: 5px;background: #fff;" id="createLinks">点击生成推广链接</button>
						<input  style="display:none;margin:15px 0;width:425px;" id="pro_url" type="text" class="linkinput form-control" value="">

                    </div>
					

                    <script>
                        $("#createLinks").click(function () {
                            _roomLinks = $("#roomLinks").val();
                            if (_roomLinks!=''){
                                _pro_url = _roomLinks+'/?forumid={{$userinfo->id}}&user_id={{rand(1000000, 9999999)}}&token={{md5(env('APP_KEY').$userinfo->id)}}';
                                $("#pro_url").val(_pro_url);
                                $("#pro_url").show();
                            } else {
                                alert("推广直播间url不得为空");
                            }
                        })
                    </script>					
					
					
                    <div class="clear"></div>
                    <div class="recording">
                        <div class="recordtit"> <span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的邀请 </div>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>时间</th>
                                <th>来源者</th>
                                <th>来源者手机号</th>
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
                                <td><strong>
                                        {{$a->user->phone}}
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
                    <div class="clear"></div>
                    <div class="recording">
                        <div>
                            <div class="recordtit"><span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>奖励规则</div>
                        </div>
                        <div class="clear"></div>
                        <div class="reward_rules">
                            <ol>
                                <li>①  您每推荐一个好友注册，好友可以获得{{config('promotion.register_award')}}金币。</li>
                                <li>②  被邀请的好友从注册日期一年内消费（赠送礼物），邀请人可获得奖励。否则邀请奖励不再发放。</li>
                                <li>③  活动中如果发现通过作弊手段获得奖励的，将取消奖励。</li>
                                <li>④  新规则从2017年1月24日起对所有用户开放。</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!--右侧结束-->
        </div>
    </div>
    <div style="height:60px;"></div>
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
                previous : "←",
                next : "→",
                perPage : 5,
            });
        });

        $(".linkbtn").on('click',function(){
            var e=document.getElementById("linkinput");
            e.select();
            document.execCommand("Copy");
            layer.msg('复制成功！', {icon: 1});
        });
    </script>
    @stop	

