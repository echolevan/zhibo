<?php

namespace App\Http\Controllers\Admin;

use App\Models\Withdrawals;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WithdrawalsController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
           '_withdrawals' => 'am-in'
        ]);
    }

    //管理员提现控制器
    public function examine()//提现待审核列表
    {
    
        $withdrawals = Withdrawals::where('status', 1)->orderBy('create_time', 'desc')->get();
        return view('admin.withdrawals.examine')->with('withdrawals', $withdrawals);
    }

    public function wait_pay()//提现待打款列表
    {
        $withdrawals = Withdrawals::where('status', 2)->orderBy('create_time', 'desc')->get();
        return view('admin.withdrawals.wait_pay')->with('withdrawals', $withdrawals);
    }

    public function fail_examine()//审核未通过列表
    {
        $withdrawals = Withdrawals::where('status', 20)->orderBy('create_time', 'desc')->get();
        return view('admin.withdrawals.fail_examine')->with('withdrawals', $withdrawals);
    }

    public function success_pay()//提现成功列表
    {
        $withdrawals = Withdrawals::where('status', 3)->orderBy('create_time', 'desc')->get();
        return view('admin.withdrawals.success_pay')->with('withdrawals', $withdrawals);
    }

    public function edit_examine(Request $request)//审核通过提交
    {
        $withdrawals = Withdrawals::find($request->id);
        if (empty($withdrawals) || $withdrawals->status != 1) return $this->return_api(false, '没有这笔提现请求');
        $withdrawals->status = 2;
        $withdrawals->save();
        return back()->with('msg', '成功');
    }

    public function fail_examine_store(Request $request)//审核失败提交
    {
//        return $request->all();
        $withdrawals = Withdrawals::find($request->id);
        if (empty($withdrawals) || $withdrawals->status != 1) return $this->return_api(false, '没有这笔提现请求');
        $withdrawals->status = 20;
        $withdrawals->examine_status = $request->fail;
        $withdrawals->save();
        $user = User::find($withdrawals->user_id);
        $user->award = $user->award + ($withdrawals->amount)*10;
        $user->save();
        return $this->return_api(true, '成功');

    }

    public function return_examine(Request $request)//审核未通过状态改为审核中
    {
        $withdrawals = Withdrawals::find($request->id);
        if (empty($withdrawals) || $withdrawals->status != 20) return $this->return_api(false, '没有这笔提现请求');
        $withdrawals->status = 1;
        $withdrawals->save();
        $user = User::find($withdrawals->user_id);
        $user->award = $user->award - ($withdrawals->amount)*10;
        $user->save();
        return back()->with('msg', '更改成功');
    }

    public function edit_wait_pay(Request $request)//提现提交,在这里抽取分红
    {

    }

    public function examine_role()//讲师提现规则设置页面
    {
        $role = config('teacher_withdrawals_role');
        return view('admin.withdrawals.role')->with(compact('role'));
    }

    public function user_examine_role()//用户提现规则设置页面
    {
        $role = config('user_withdrawals_role');
        return view('admin.withdrawals.user_role')->with(compact('role'));
    }

    public function examine_role_store(Request $request)//提现规则设置提交
    {
        if ($request->type == 'teacher') {
            $status = $this->config_set('teacher_withdrawals_role', $request->all());
        }
        if ($request->type == 'user') {
            $status = $this->config_set('user_withdrawals_role', $request->all());
        }
        if (isset($status) && $status === true) {
            return back()->with('msg', '更改成功');
        }
        return back()->with('error', '更改失败');
    }


}
