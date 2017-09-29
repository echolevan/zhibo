@extends('home.layout.app')
@section('content')
    <!--heade结束-->
    <!--修改密码-->
    <div class="change">
        <div class="c-step">
            <div class="steptit">收入提现</div>
        </div>
        <div class="Realname">
            <div style="width:350px; margin:auto;">
                <form action="{{route('withdrawals_store')}}" method="post">
                    {{csrf_field()}}
                    <div class="mt15 text-center" style="margin-bottom:20px; margin-left:-50px;">
                        <strong>可提现</strong>
                        <span style="color: #ff4436; font-size: 25px;font-weight: 400; position: relative;top: -3px;padding: 0 2px;line-height: 34px;">{{$userinfo->award/10}}</span>元
                    </div>
                    <div class="clear"></div>
                    <div class="mt15">
                        <label>提现金额：</label>
                        <input type="text" name="amount" class="oldtext form-control" placeholder="">
                    </div>
                    <div class="clear"></div>
                    <div class="mt15">
                        <label>收款姓名：</label>
                        <input type="text" name="user_name" class="oldtext form-control" placeholder="">
                    </div>
                    <div class="clear"></div>
                    <div class="mt15">
                        <label>收款类型：</label>
                        <input type="text" name="account_type" class="oldtext form-control" placeholder="支付宝、微信或银行名称">
                    </div>
                    <div class="clear"></div>
                    <div class="mt15">
                        <label>收款账户：</label>
                        <input type="text" name="account" class="oldtext form-control" placeholder="">
                    </div>
                    <div class="clear"></div>
                    <div class="stepbtn1 mt15" style="margin-left:85px; margin-top:20px;">
                        <button type="submit" class="btn steppink1">
                            确认提现
                        </button>
                    </div>
                    <div class="clear"></div>
                    <div class="mt15" style="margin-left:100px; margin-top:50px;">
                        <p style="text-align: left; margin-bottom:10px;">提现须知：</p>
                        <p style="text-align: left; font-size:12px; color:#999; line-height:25px;margin:0px;">
                            1、可提现到本人的支付宝或银行卡账户。</p>
                        <p style="text-align: left; font-size:12px; color:#999; line-height:25px; margin:0px;">
                            2、每月结算后提现次数不超过4次，请您合理规划使用。</p>
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <p style="height:60px;"></p>
        </div>
    </div>
@stop