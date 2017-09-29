<?php

namespace App\Http\Controllers\Home\Customer;

use App\Http\Controllers\Home\CommonController;
use App\Models\Live_history;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class LiveController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        view()->share([
            '_live' => 'on'
        ]);
    }

    public function index($id)
    {
        $customer = User::with('lecturer.room','oauth')->where('type',2)->find($id);
        //判断该用户是否存在
        if(empty($customer)){
            return redirect(route('home'));
        }
        //判断该主播是否有房间
        if(empty($customer->lecturer->room)){
            return redirect(route('home'));
        }
        $history = Live_history::with('user')->where('user_id',$id)->where('status',1)->orderBy('id','desc')->paginate(10);
        return view('home.customer.live')->with('customer',$customer)->with('history',$history);
    }
}
