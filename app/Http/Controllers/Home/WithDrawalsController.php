<?php

namespace App\Http\Controllers\Home;

use App\Models\Award;
use App\Models\Gift_history;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class WithDrawalsController extends CommonController
{

    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_drawal' => 'on'
        ]);
    }

    public function index()//用户资产中心页面
    {
        $ws = Withdrawals::where('user_id', $this->user->id)->orderBy('id','desc')->get();
        $gifts = Gift_history::with('gift')->where('receiver_id', $this->user->id)->get();
        $awards = Award::with('user')->where('user_id',$this->user->id)->orderBy('id','desc')->get();
        return view('home.user.property.withdrawals_history')->with(compact('ws', 'gifts','awards'));
    }

    public function create()//用户申请提现页面
    {
        if ($this->user->award <= 0) {
            return back()->with('error', '您的可提现金额为0');
        }
        return view('home.user.property.withdrawals');//申请提现页面
    }

    public function store(Request $request)//用户申请提现提交
    {
        if ($this->user->award <= 0) {
            return back()->with('error', '您的可提现金额为0');
        }
        $request->amount = intval($request->amount);
        if ($request->amount <= 0 || ($request->amount)*10 > $this->user->award ||
            empty($request->amount) || empty($request->account) ||
            empty($request->account_type)
        ) {
            return back()->with('error', '您填写的信息不够完整或有误');
        }
        $status = self::vali_type($request->amount);
        if (is_array($status)) {
            return back()->with('error', $status['msg']);
        }
        $info = array(
            'user_name' => $request->user_name,
            'user_type' => $this->user->type,
            'user_id' => $this->user->id,
            'account_type' => $request->account_type,
            'account' => $request->account,
            'amount' => $request->amount,
            'status' => 1,
            'create_time' => Carbon::now(),
        );
        $this->user->award = $this->user->award - ($request->amount)*10;
        $this->user->save();
        Withdrawals::create($info);
        return redirect(route('withdrawals_index'));
    }

    public function vali_type($money)//检查提现规则
    {
        if ($this->user->type == 1) {//会员
            $config = config('user_withdrawals_role');
        }
        if ($this->user->type == 2) {//讲师
            $config = config('teacher_withdrawals_role');
        }
        if (!isset($config)) {
            dd('用户数据库类型错误');
        }
        $status = self::vali_with($config, $money);
        if (is_array($status)) {
            return $status;
        }
        return true;
    }

    public function vali_with($config, $money)
    {
        //时间，次数，最低金额
        $dtime = date('d', time());
        if ($config['time'] != $dtime && !empty($config['time'])) {
            return $this->return_api(false, '当前日期不为可提现日期');
        }
        if ($money < $config['money']) {
            return $this->return_api(false, '您的提现金额小于最小提现金额' . $config['money'] . '元');
        }
        $stime = date('Y-m-01', time());;
        $etime = date('Y-m-t');
        $counts = Withdrawals::where('user_id', $this->user->id)->
        whereNotIn('status', [10, 20, 30])->
        whereBetween('create_time', array($stime, $etime))->
        count();
        if ($counts >= $config['num'] && !empty($config['num'])) {
            return $this->return_api(false, '您的提现次数已超过最大提现次数' . $config['num'] . '次');
        }
        return true;
    }

}
