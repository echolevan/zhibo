<?php

return [

    // The default gateway to use
    //'default' => 'alipay',

    // Add in each gateway here
    'min_pay' => '1',
    'gateways' => [
        'paypal' => [
            'driver' => 'PayPal_Express',
            'options' => [
                'solutionType' => '',
                'landingPage' => '',
                'headerImageUrl' => ''
            ]
        ],
        'alipay' => [
            'driver' => 'Alipay_LegacyExpress', //及时到账
            'options' => [
                'partner' => '2088621535998419',
                //--收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
                'key' => '7uobslsle6xvnjdxgxlp01z4dmjgaj95', //接口id
                'sellerEmail' => '719261458@qq.com', //卖方邮箱
                'returnUrl' => env('APP_URL') . '/pay/record', //同步返回地址
                'notifyUrl' => env('APP_URL') . '/pay/alipayNotify'   //异步通知地址notify
            ]
        ],
        'weixinpay' => [
            'driver' => 'WechatPay_Native',
            'options' => [
                'appid' => 'wxac0baa8531509bab',   //应用id
                'mchid' => '1395403202',//商户号
                'notifyurl'=>env('APP_URL').'/pay/wxpayNotify',
                'apikey' => 'zxtc2016zxtc2016zxtc2016zxtc2016',  //秘钥
            ]
        ],
    ]

];