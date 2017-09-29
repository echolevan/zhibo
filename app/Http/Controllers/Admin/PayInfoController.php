<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;

use App\Http\Requests;

class PayInfoController extends CommonController
{
    public function index(Request $request)
    {
        $pay_log = Order::with('user')->orderBy('id','desc')->where('amount','!=',0)->where('status',2)->paginate(15);
        return view('admin.payinfo.index')->with('pay_log',$pay_log);
    }
}
