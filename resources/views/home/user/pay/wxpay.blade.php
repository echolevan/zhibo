@extends('home.layout.app')
@section('content')
    <div class="change">
        <div class="c-step">
            <div class="steptit">微信支付</div>
        </div>
        <div class="Realname">
            <div>
                <form>

                    <div  class="mt15">
                        <li>
                            <span style=" width:250px;height:250px; display:block; margin:auto;">
                                <img alt="扫码支付" src="{{url('/pay/wxpng',$pngsrc)}}">
                            </span>
                            <span style="padding-left: 160px;">使用微信扫码付款</span>
                        </li>
                    </div>
                    <div class="clear"></div>
                </form>

            </div>
            <div class="clear"></div>
            <p style="height:60px;"></p>
        </div>
    </div>
@stop