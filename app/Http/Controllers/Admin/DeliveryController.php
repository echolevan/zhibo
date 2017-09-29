<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profit;
use App\Models\Stock_data;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class DeliveryController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $where = function ($query) use ($request){
            if($request->has('name') and $request->name != ''){
                $search = "%" . $request->name . "%";
                $query->where('a.name', 'like', $search);
            }
        };
        $countUserId = Profit::select('user_id')->distinct()->get();
        $counts = DB::table('profits')
            ->leftjoin('users as a','a.id','=','profits.user_id')
            ->select('user_id',DB::raw('sum(earnings) as sum_earnings'),DB::raw('sum(gain) as sum_gain'),'a.name as username')
            ->whereIn('user_id',$countUserId)
            ->where($where)
            ->groupBy('user_id')
            ->orderBy(DB::raw('sum(gain)'), 'desc')
            ->paginate(12);
        return view('admin.delivery.index')->with('counts',$counts);
    }

    public function dataList($user_id)
    {
        $check_user = User::find($user_id);
        if(empty($check_user) and $check_user->type != 2){
            return redirect(route('admin.delivery'));
        }
        $delivery = Profit::with('user')->orderBy('id','desc')->where('user_id',$user_id)->paginate(10);
        return view('admin.delivery.list')->with('delivery',$delivery);
    }

    public function details($user_id,$id)
    {
        $check_user = User::find($user_id);
        if(empty($check_user) and $check_user->type != 2){
            return redirect(route('admin.delivery'));
        }
        $check_profit = Profit::find($id);
        if(empty($check_profit)){
            return redirect(route('admin.delivery'));
        }
        $data_id = explode(',',str_replace(']','',str_replace('[','',$check_profit->stock_data_id)));
        $details = Stock_data::whereIn('id',$data_id)->paginate(12);
        return view('admin.delivery.details')->with('details',$details);
    }

    public function delete(Request $request)
    {
        $profit = Profit::find($request->id);
        $data_id = explode(',',str_replace(']','',str_replace('[','',$profit->stock_data_id)));
        Stock_data::destroy($data_id);
        Profit::destroy($request->id);
        return ['status' => true,'msg' => '删除成功'];
    }
}
