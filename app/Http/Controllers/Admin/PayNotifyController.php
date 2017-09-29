<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PayNotifyController extends Controller
{
    //
    public function alipay_notify()//支付宝异步回调
    {

    }

    public function weixinpay_notify()//微信异步回调
    {

    }

    public function pid_add_award($user, $money)//上级增加可提现金额
    {
        $puser = User::find($user->pid);
        if (empty($puser)) return;
        $award = config('siteinfo')['award'];
        $puser->award = $puser->award + (($money * $award) / 100);
        $puser->save();
    }
}
