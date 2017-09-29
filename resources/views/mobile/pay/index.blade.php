@extends('mobile.layout.app')
        @section('css')
        <style>
            body{background:#f5f5f5;}
            #pay button{width: 100%;
                background: #fd735c;
                text-align: center;
                line-height: 50px;
                color: #fff;
                display: block;
                font-size: 1.2em;
                position:fixed; bottom:0;}
        </style>
        @stop
@section('content')
        <!--顶部固定条-->
<div class="navbar navbar-default navbar-fixed-top nav-top"  style="margin-bottom:0px; background:#fff; border-bottom:#ddd solid 1px;">
    <div style="height:40px;">
        <ul style="line-height:50px;">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left"><a href="{{route('mobile.customer')}}">
                    <i style="width:12px;display:block; float:left; margin-top:15px; margin-left:5px;"><img src="/homestyle/m_img/back.png" class=" img-responsive"></i></a></li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center" style="font-size:1.2em;"><a href="">我的钱包</a></li>
        </ul>
    </div>
</div>
<!--顶部固定条end-->
<!--主界面内容-->
<div style="margin-top:60px;">
    <div class="mywallet">
        <p class="yue">余额：<span>{{$user->gold}}</span> 金币</p>
    </div>
    <div class="myamount">
        <p class="exchange">金币充值 10金币=1元</p>
        <div class="m-num">
            <ul>
                <li class="dropdown open" data-price="100">
                    <a>
                        <p class="txt1">100金币</p>
                        <p class="txt2">￥10元</p>
                    </a>
                </li>
                <li class="dropdown" data-price="500">
                    <a>
                        <p class="txt1">500金币</p>
                        <p class="txt2">￥50元</p>
                    </a>
                </li>
                <li class="dropdown" data-price="1000">
                    <a>
                        <p class="txt1">1000金币</p>
                        <p class="txt2">￥100元</p>
                    </a>
                </li>
                <li class="dropdown" data-price="2000">
                    <a>
                        <p class="txt1">2000金币</p>
                        <p class="txt2">￥200元</p>
                    </a>
                </li>
                <li class="dropdown" data-price="5000">
                    <a>
                        <p class="txt1">5000金币</p>
                        <p class="txt2">￥500元</p>
                    </a>
                </li>
                <li class="dropdown" data-price="10000">
                    <a>
                        <p class="txt1">10000金币</p>
                        <p class="txt2">￥1000元</p>
                    </a>

                </li>

            </ul>
        </div>
    </div>
    <form method="post" action="{{route('alipay')}}">
        {!! csrf_field() !!}
        <input type="hidden" name="number" value="100"/>
        <input type="submit" class="do_pay" style="display: none;"/>
    <div class="mypay bs-example" data-example-id="buttons-checkbox" >
        <ul class="btn-group " data-toggle="buttons">
            <li class="active">
                <div class="col-md-9 col-sm-9 col-xs-9 pull-left">
                    <div class="list-img"> <img src="/homestyle/m_img/zfb.png" class="img-responsive"> </div>
                    <div class="list-txt">
                        <p>支付宝支付</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 pull-right">
         <span class="right-img">
          <label class="img">
              <input tabindex="1" type="radio" name="options" id="option1" autocomplete="off" checked>
          </label>
         </span>
                </div>
            </li>
        </ul>
    </div>
        <div class="confirm" id="pay">
            <button type="button" class="pay">确认支付</button>
        </div>
    </form>
</div>

<!--主界面内容end-->
<!--底部固定导航-->
<!--底部固定导航end-->
    @stop
@section('js')
    <script>
        $('.dropdown').click(function(){
            $('.m-num ul li').removeClass('open');
            $(this).addClass('open');
            var number = $(this).data('price');
            $('input[name=number]').val(number);
        })
        $(function(){
            $('.pay').click(function(){
                var number = $('input[name=number]').val();
                if(number = ''){
                    layer.open({
                        content: '请选择金额！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }
                $('.do_pay').click();
            })
        })
    </script>
    @stop