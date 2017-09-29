@extends('home.layout.app')
@section('css')
    <style>
        .wx_style{
            height:210px;
        }
    </style>
    @stop
@section('content')
    <div class="change">
        <div class="c-step">
            <div class="steptit">充值金额</div>
        </div>
        <div class="Realname">
            <div>
                <form id="pay_action" method="post" action="{{route('alipay')}}">
                    {!! csrf_field() !!}
                    <div class="mt15">
                        <label>真实姓名：</label>
                        <ul class="czselect">
                            <li data-price="100" class="curr price">1000金币</li>
                            <li data-price="200">2000金币</li>
                            <li data-price="500">5000金币</li>
                            <li data-price="1000">10000金币</li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <div  class="mt15">
                        <label>自定义数量：</label>
                        <input name="number"  type="text" value="1000" class="oldtext form-control" placeholder="请填写正整数！">
                    </div>
                    <div class="clear"></div>
                    <div  class="mt15">
                        <label>应付金额：</label>
                        <span class="czmoney"><strong>100.00</strong> 元</span> </p>
                    </div>
                    <div class="clear"></div>
                    <div  class="mt15">
                        <label>支付方式：</label>
                        <ul class="paymeth">
                            <li data-type="alipay" class=""><img src="/homestyle/images/zfb.png" class="img1"></li>
                            <li data-type="wxpay" class="dropdown">
                                <a href="#" data-toggle="dropdown" data-target="#dropdown" id="dropdownMenu">
                                    <img src="/homestyle/images/wx1.png" class="img1"></a>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <div class="stepbtn1 mt15 wx_style" style="margin-left:85px; margin-top:20px;">
                        <button type="button" class="btn steppink" id="pay">提交支付</button>
                        <input type="submit" style="display :none;" class="pay" />
                        <button type="button" class="btn btn-default stepwhite" onclick="window.location.reload()">取消</button>
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <p style="height:60px;"></p>
        </div>
    </div>
    <input type="hidden" id="min_pay" value="{{config('laravel-omnipay.min_pay')}}">
    @stop
@section('js')
    <script>
        $(function(){
            $('.czselect li').click(function(){
                $('.czselect li').removeClass('curr price');
                $(this).addClass('curr price');
                var number = $(this).data('price');
                $('.czmoney strong').text(number+'.00');
                $('input[name=number]').val(number*10);
            });

            $('.paymeth li').click(function(){
                $('.paymeth li').removeClass('curr type');
                $(this).addClass('curr type');
            });
            $('#pay').click(function(){
                var number = $('input[name=number]').val();
                if(!number){
                    var number = $('.price').data('price');
                }
                var ex = /^\d+$/;      //判断是否为正整数
                var reg = /.*\..*/;   //判断是否是小数
                var min_pay = parseInt($('#min_pay').val());
                if (ex.test(number) && number >= min_pay && !reg.test(number)) {
                    var type = $('.type').data('type');
                    if(!type){
                        layer.msg('请选择支付方式！');
                        return false;
                    }
                    if(type == 'wxpay'){
                        var url = "{{route('wxpay')}}";
                        $("#pay_action").attr("action", url);
                    }
                    if(type == 'alpay'){
                        var url = "{{route('alipay')}}";
                        $("#pay_action").attr("action", url);
                    }
                    $('.pay').click();
                    return true;
                } else {
                    layer.tips('充值金额不得低于'+min_pay+'元且为整数', '.oldtext');
                    return false
                }
            });


            $('input[name=number]').keyup(function(){
                var money = $(this).val();
                $('.czmoney strong').text(money/10+'.00');
                $('.czselect li').removeClass('curr');
                if(money == ''){
                    $('.czselect li:first').addClass('curr');
                    var number = $('.czselect li:first').data('price');
                    $('.czmoney strong').text(number+'.00');
                    $('input[name=number]').val(number*10)
                    return false;
                }
//                var money = parseInt(money);  //转换过后不保留小数点
//                var ex = /^\d+$/;      //判断是否为正整数
//                var reg = /.*\..*/;   //判断是否是小数
//                var min_pay = parseInt($('#min_pay').val());
//                if (ex.test(money) && money >= min_pay && !reg.test($(this).val())) {
//                    return true;
//                } else {
//                    layer.tips('充值金额不得低于'+min_pay+'元且为整数', 'oldtext');
//                    return false
//                }
            })
        })
    </script>
    @stop