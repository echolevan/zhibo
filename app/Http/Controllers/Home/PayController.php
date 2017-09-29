<?php

namespace App\Http\Controllers\Home;

use App\Models\Consume;
use App\Models\Order;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use Omnipay;

class PayController extends CommonController
{
    //
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_pay' => 'on'
        ]);
    }

    //交易记录
    public function payRecord()
    {
        //消费记录
        $consumes = Consume::orderBy('id', 'desc')->where('user_id', $this->user->id)->get();
        //充值记录
        $pay_log = Order::orderBy('id', 'desc')->where('user_id', $this->user->id)->where('amount', '!=', 0)->where('status', 2)->get();
        return view('home.user.pay.index')->with('consumes', $consumes)->with('pay_log', $pay_log);
    }

    //充值页面
    public function payType()
    {
        return view('home.user.pay.type');
    }


    public function alipay(Request $request, $type = 'alipay')//阿里支付
    {
        if (empty($request->number)) {
            return back()->with('error', '请填写充值金额！');
        }
        if (!preg_match("/^[0-9][0-9]*$/", $request->number)) {
            return back()->with('error', '金额请填写正整数！');
        }
        if ($request->number < config('laravel-omnipay.min_pay')) {
            return back()->with('error', '充值金额过低！');
        }
        $gateway = Omnipay::gateway('alipay');
        if (empty($gateway)) {
            return back()->with('error', '非法操作！');
        }
        $order = array(
            'order_id' => $this->create_order_num(), //--订单id
            'user_id' => $this->user->id,
            'status' => 1,
            'amount' => $request->number / 10,     //-- 充值金额
            'type' => 1,
            'created_time' => Carbon::now(),
        );
//        --创建订单s
//        --生成订单数据
        if (Order::create($order)) {
            $goods = array();
            $goods['subject'] = '充值金币';            //消费内容
            $goods['out_trade_no'] = $order['order_id'];   //订单号id
            $goods['total_fee'] = $request->number / 10;         //全部费用
            if ($type == 'alipay') {
                $response = $gateway->purchase($goods)->send();   //跳转到pc端支付页面，显示goods信息
                $response->redirect();
            } else {
                return redirect('/');
            }
        }
    }

    private function create_order_num()
    {
        $rand = mt_rand(0, 999);
        $rand = 2 == strlen($rand) ? ('0' . $rand) : $rand;
        $rand = 1 == strlen($rand) ? ('00' . $rand) : $rand;
        list($usec, $sec) = explode(" ", microtime());
        $time = $usec + (float)$sec;
        $order_id = 'ME' . substr(str_replace('.', '', $time), 0, 13) . $rand;
        return $order_id;
    }

    public function wxpay(Request $request)
    {
        if (empty($request->number)) {
            return back()->with('error', '请填写充值金额！');
        }
        if (!preg_match("/^[0-9][0-9]*$/", $request->number)) {
            return back()->with('error', '金额请填写正整数！');
        }
        if ($request->number < config('laravel-omnipay.min_pay')) {
            return back()->with('error', '充值金额过低！');
        }
        $gateway = Omnipay::gateway('weixinpay');
        if (empty($gateway)) {
            return back()->with('error', '非法操作！');
        }
        $order = array(
            'order_id' => self::create_order_num(), //--订单id
            'user_id' => $this->user->id,
            'status' => 1,
            'amount' => ($request->number) / 10,     //-- 充值金额
            'created_time' => Carbon::now(),
            'type' => 2,
        );
        if (Order::create($order)) {
            $goods = [
                'body' => '金币充值',
                'out_trade_no' => $order['order_id'],
                'total_fee' => $order['amount'] * 100,
                'attach' => $this->user->id,
                'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
                'fee_type' => 'CNY'
            ];
            $resul = $gateway->purchase($goods);
            $response = $resul->send();
            return view('home.user.pay.wxpay')->with('pngsrc', urlencode($response->getCodeUrl()));
        } else {
            return ['status' => false, 'msg' => '操作失败！'];
        }
    }

    //生成订单号

    public function wxpng($pngcode)
    {
        $qrCoode = new QrCode(urldecode($pngcode));
        $qrCoode->setMargin(0)->setSize(250);
        return response($qrCoode->writeString(), 200)->header('Content-Type', "image/png");
    }

}
