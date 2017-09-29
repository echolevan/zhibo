<?php
/**
 *  支付类
 * ============================================================================
 * * 版权所有 2016-2018   网络科技有限公司，并保留所有权利。
 * 网站地址:
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: lisonglin
 * Id:PayController.php  2016年8月19日  Lisonglin
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Omnipay;
use Symfony\Component\HttpFoundation\Request;

class PayNotifyController extends Controller
{
    //--订单长度
    const order_length = 18;
    //--订单前缀
    const order_prex = 'ME';

    //通知地址
    public function alipayNotify(Request $request)
    {
        file_put_contents(base_path('storage/logs/alipay_test.log'), date("Y-m-d H:i:s") ."alipay notify ok", FILE_APPEND);
        $gateway = Omnipay::gateway('alipay');
        $request = $gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET));
        $errorLogPath = base_path('storage/logs/alipay_error.log');
        try {
            $response = $request->send();
            if ($response->isPaid()) {
                $order = Order::where('order_id', $_REQUEST['out_trade_no'])
                    ->where('status', 1)->first();
                if ($order===null) {    //状态已经改变
                    exit('success');
                }
                $UID = $order->user_id;
                if ($order->id > 1) {
                    $order->status = 2;   //修改order表中状态
                    $order->updated_time = Carbon::now();
                    $order->save();  //保存成功后，在log表中保存这条数据
                }
                $user = User::where('id',$UID)->first();
                $user->gold = $user->gold + ($_REQUEST['total_fee'])*10;
                $user->save();
                if($user->pid != 0){
                    Award::create([
                        'user_id' => $user->pid,
                        'from_id' => $user->id,
                        'type' => 2,
                        'price'=> ($_REQUEST['total_fee']*config('promotion.pay_award')/100),
                        'created_time' => Carbon::now()
                    ]);
                    $p_user = User::find($user->pid);
                    $p_user->update(['award' => $user->award + ($_REQUEST['total_fee']*config('promotion.pay_award')/100)]);
                }
                exit('success');
            } else {
                file_put_contents($errorLogPath, date("Y-m-d H:i:s") + "\t alipay order verify faild! error info: " + var_export($request, true) + "\r\n\r\n", FILE_APPEND);
                exit('fail');
            }
        } catch (\Exception $e) {
            file_put_contents($errorLogPath, date("Y-m-d H:i:s") + "\t alipay order notify exception! exception info : " + $e->getMessage() + "\t error info: " + var_export($request, true) + "\r\n\r\n", FILE_APPEND);
            exit('fail');
        }
    }

    public function wxpayNotify(Request $request)
    {

        $gateway = Omnipay::gateway('weixinpay');
        $errorLogPath = base_path('storage/logs/wxpay_erro.log');
        $xml = json_decode(json_encode(simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $ordered = Payment_order::where('order_id',$xml['out_trade_no'])->where('payment_status',10)->select('id')->first();
        $loged = Payment_log::where('order_id',$xml['out_trade_no'])->select('id')->first();
        if($ordered!=null || $loged!= null){
            file_put_contents($errorLogPath, var_export('本次属于重复调用', true), FILE_APPEND);
            return self::array2xml(true);exit();
        }
        try {
            $response = $gateway->completePurchase([
                'request_params' => file_get_contents('php://input')
            ])->send();
            if ($response->isPaid()) {
                //验证通过，attach为用户id,total_fee为支付金额单位分，out_trade_no订单号
                $order = Payment_order::where('order_id', $xml['out_trade_no'])
                    ->where('payment_status', 0)->first();
                if ($order->id > 1) {
                    $order->payment_status = 10;   //修改order表中状态
                    $order->update_time = time();
                    $order->save();  //保存成功后，在log表中保存这条数据
                }else{
                    file_put_contents($errorLogPath, date("Y-m-d H:i:s") + "\t pament_order表中无此笔订单 "+ "\t error info: " + var_export($request, true) + "\r\n\r\n", FILE_APPEND);
                }
                $date = array(   //log表
                    'order_id' => $xml['out_trade_no'],
                    'uid' => $xml['attach'],
                    'payment_method' => 'wxpay',
                    'pay_status' => 1,
                    'amount' => $xml['total_fee']*0.01,
                    'create_time' => time(),
                );
                Payment_log::create($date);
                $user = User::where('id',$xml['attach'])->first();
                $user->gold = $user->gold+$date['amount'];
                $user->save();
                $sharing = new CommisssionSharing();
                $sharing->index($date['amount'],$date['uid']);
                return self::array2xml(true);exit();
            } else {
                file_put_contents($errorLogPath, date("Y-m-d H:i:s") + "\t wxpay order verify faild! error info: " + var_export($request, true) + "\r\n\r\n", FILE_APPEND);
                return self::array2xml(false);exit();
            }
        }catch (Exception $e){
            file_put_contents($errorLogPath, date("Y-m-d H:i:s") + "\t wxpay order notify exception! exception info : " + $e->getMessage() + "\t error info: " + var_export($request, true) + "\r\n\r\n", FILE_APPEND);
            exit('fail');
        }
    }

    public function array2xml($status, $root = 'xml')
    {
        $arr = $status ? array(
            'return_code'=>'SUCCESS',
            'return_msg'=>'OK'
        ) :array(
            'return_code'=>'FAIL',
            'return_msg'=>'校验失败或参数格式错误'
        );
        $xml = "<$root>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;

    }

}
