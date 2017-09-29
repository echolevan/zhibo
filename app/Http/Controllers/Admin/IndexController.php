<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends CommonController
{
    //本周起止时间unix时间戳
    private $week_start;
    private $week_end;
    public function __construct()
    {
        $this->week_start = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));
        $this->week_end = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7, date("Y"));;
        parent::__construct();
    }

    public function index()
    {
        $user_count = User::count();
        $lecturer_count = User::where('type',2)->count();
        $user_week = User::whereBetween('created_at',[date('y-m-d h:i:s',$this->week_start),date('y-m-d h:i:s',$this->week_end)])->count();
        $lecturer_week = User::whereBetween('created_at',[date('y-m-d h:i:s',$this->week_start),date('y-m-d h:i:s',$this->week_end)])->where('type',2)->count();
        return view('admin.index')->with('user_count',$user_count)->with('lecturer_count',$lecturer_count)->with('user_week',$user_week)->with('lecturer_week',$lecturer_week);
    }
}
